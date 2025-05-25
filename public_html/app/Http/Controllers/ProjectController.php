<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Collaboration;
use App\Models\User;
use App\Notifications\NewProjectNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Notifications\CollaborationRequestNotification;
use App\Notifications\CollaborationResponseNotification;
use App\Models\Message;
use App\Notifications\ProjectMessageNotification;
use App\Notifications\CollaborationRemovedNotification;
use App\Events\CollaborationUpdated;
use App\Events\SkillUpdated;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query()
            ->with(['user', 'collaborators'])
            ->withCount('collaborators');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->whereJsonContains('skills_required', $skills);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate(9);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = \App\Models\Skill::all();
        return view('projects.form', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,completed,on_hold',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'skills_required' => 'required|array',
        ]);

        $project = Project::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'skills_required' => $validated['skills_required'],
        ]);

        Activity::log(
            auth()->user(),
            'project_created',
            $project,
            'Created a new project: ' . $project->title
        );

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['user', 'collaborators', 'collaborationRequests']);
        $isOwner = auth()->id() === $project->user_id;
        $isCollaborator = $project->isCollaborator(auth()->user());
        $hasPendingRequest = $project->hasPendingRequest(auth()->user());
        
        return view('projects.show', compact('project', 'isOwner', 'isCollaborator', 'hasPendingRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $skills = \App\Models\Skill::all();
        return view('projects.form', compact('project', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,completed,on_hold',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'skills_required' => 'required|array',
        ]);

        $oldSkills = $project->skills_required;
        $project->update($validated);

        // If skills were changed, notify all users who have these skills
        if ($oldSkills !== $validated['skills_required']) {
            $affectedSkills = array_merge($oldSkills, $validated['skills_required']);
            $affectedSkills = array_unique($affectedSkills);
            
            foreach ($affectedSkills as $skillName) {
                $skill = Skill::where('name', $skillName)->first();
                if ($skill) {
                    // Notify all users who have this skill
                    $skill->users->each(function($user) use ($skill) {
                        event(new SkillUpdated($skill, $user->id));
                    });
                }
            }
        }

        Activity::log(
            auth()->user(),
            'project_updated',
            $project,
            'Updated project: ' . $project->title
        );

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $projectTitle = $project->title;
        $project->delete();

        Activity::log(
            auth()->user(),
            'project_deleted',
            $project,
            'Deleted project: ' . $projectTitle
        );

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function collaborate(Request $request, Project $project)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        // Check if user already has a pending request
        if ($project->hasPendingRequest(auth()->user())) {
            return back()->with('error', 'You already have a pending collaboration request for this project.');
        }

        // Create collaboration request
        $collaboration = Collaboration::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'message' => $validated['message'] ?? null,
        ]);

        // Notify project owner
        $project->user->notify(new CollaborationRequestNotification($project, auth()->user()));

        Activity::log(
            auth()->user(),
            'collaboration_requested',
            $project,
            'Requested to collaborate on project: ' . $project->title,
            ['message' => $validated['message'] ?? null]
        );

        return back()->with('success', 'Collaboration request sent successfully.');
    }

    public function manageCollaboration(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:accept,reject',
            'welcome_message' => 'nullable|string|max:500',
        ]);

        $collaborator = User::findOrFail($validated['user_id']);
        $collaboration = $project->collaborations()
            ->where('user_id', $collaborator->id)
            ->firstOrFail();

        if ($validated['action'] === 'accept') {
            $collaboration->update(['status' => 'accepted']);
            $project->collaborators()->attach($collaborator->id);

            // Create welcome message
            $message = Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $collaborator->id,
                'project_id' => $project->id,
                'content' => $validated['welcome_message'] ?? "Welcome to the project! We're excited to have you on board.",
                'type' => 'collaboration_welcome'
            ]);

            // Notify the collaborator
            $collaborator->notify(new CollaborationResponseNotification($project, true));
        } else {
            $collaboration->update(['status' => 'rejected']);
            $collaborator->notify(new CollaborationResponseNotification($project, false));
        }

        // Dispatch the collaboration updated event
        event(new CollaborationUpdated($collaboration, $collaborator->id));

        return back()->with('success', 'Collaboration request ' . $validated['action'] . 'ed successfully.');
    }

    public function storeMessage(Request $request, Project $project)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'project_id' => $project->id,
            'content' => $validated['content'],
            'type' => 'project_message'
        ]);

        // Notify all project collaborators except the sender
        $project->collaborators()
            ->where('user_id', '!=', auth()->id())
            ->get()
            ->each(function ($collaborator) use ($message) {
                $collaborator->notify(new ProjectMessageNotification($message));
            });

        Activity::log(
            auth()->user(),
            'message_sent',
            $project,
            'Sent a message in project: ' . $project->title
        );

        return back()->with('success', 'Message sent successfully.');
    }

    public function removeCollaborator(Project $project, User $collaborator)
    {
        $this->authorize('update', $project);

        // Remove from collaborators
        $project->collaborators()->detach($collaborator->id);

        // Update collaboration status
        $project->collaborations()
            ->where('user_id', $collaborator->id)
            ->update(['status' => 'rejected']);

        // Notify the removed collaborator
        $collaborator->notify(new CollaborationRemovedNotification($project));

        Activity::log(
            auth()->user(),
            'collaborator_removed',
            $project,
            'Removed collaborator ' . $collaborator->name . ' from project: ' . $project->title
        );

        return back()->with('success', 'Collaborator removed successfully.');
    }

    public function getMessages(Request $request, Project $project)
    {
        $after = $request->query('after');
        
        $messages = $project->messages()
            ->with('sender')
            ->when($after, function ($query) use ($after) {
                return $query->where('created_at', '>', $after);
            })
            ->latest()
            ->get();

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'created_at' => $message->created_at,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'profile_picture_url' => $message->sender->profile_picture_url
                    ]
                ];
            })
        ]);
    }

    public function collaborations()
    {
        $user = auth()->user();
        $collaborations = $user->collaborations()
            ->with(['project', 'project.user'])
            ->latest()
            ->paginate(10);

        return view('collaborations.index', compact('collaborations'));
    }
}
