<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ForumPost;
use App\Models\Message;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'projects' => Project::count(),
            'forum_posts' => ForumPost::count(),
            'messages' => Message::count(),
            'reports' => Report::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('user')->latest()->take(5)->get();
        $recentReports = Report::with(['reporter', 'reported'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects', 'recentReports'));
    }

    public function users()
    {
        $users = User::withCount(['projects', 'forumPosts', 'sentMessages'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:entrepreneur,admin',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function projects()
    {
        $projects = Project::with(['user', 'collaborations'])
            ->withCount(['collaborations'])
            ->latest()
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function deleteProject(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function forumPosts()
    {
        $posts = ForumPost::with(['user', 'comments'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('admin.forum.index', compact('posts'));
    }

    public function deleteForumPost(ForumPost $post)
    {
        $post->delete();

        return redirect()->route('admin.forum.index')
            ->with('success', 'Forum post deleted successfully.');
    }

    public function reports()
    {
        $reports = Report::with(['reporter', 'reported'])
            ->latest()
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    public function handleReport(Report $report)
    {
        $report->update(['status' => 'resolved']);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report marked as resolved.');
    }
}
