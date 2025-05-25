<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use App\Events\SkillUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        
        $skills = Skill::when($query, function($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
        })
        ->when($category, function($q) use ($category) {
            return $q->where('category', $category);
        })
        ->withCount('users')
        ->orderBy('users_count', 'desc')
        ->paginate(20);

        return view('skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $skill = Skill::create($validated);
        
        // Dispatch event for all users who might be interested in this skill
        event(new SkillUpdated($skill, auth()->id()));

        return back()->with('success', 'Skill created successfully.');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $skill->update($validated);
        
        // Dispatch event for all users who have this skill
        $skill->users->each(function($user) use ($skill) {
            event(new SkillUpdated($skill, $user->id));
        });

        return back()->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        
        // Dispatch event for all users who had this skill
        $skill->users->each(function($user) use ($skill) {
            event(new SkillUpdated($skill, $user->id));
        });

        return back()->with('success', 'Skill deleted successfully.');
    }

    public function attachToUser(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'level' => 'required|string|in:beginner,intermediate,advanced,expert',
            'experience_years' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $user->skills()->attach($skill->id, [
            'level' => $validated['level'],
            'experience_years' => $validated['experience_years']
        ]);

        // Dispatch event for the user
        event(new SkillUpdated($skill, $user->id));

        return back()->with('success', 'Skill added to your profile successfully.');
    }

    public function detachFromUser(Skill $skill)
    {
        $user = auth()->user();
        $user->skills()->detach($skill->id);

        // Dispatch event for the user
        event(new SkillUpdated($skill, $user->id));

        return back()->with('success', 'Skill removed from your profile successfully.');
    }

    public function updateUserSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'level' => 'required|string|in:beginner,intermediate,advanced,expert',
            'experience_years' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $user->skills()->updateExistingPivot($skill->id, [
            'level' => $validated['level'],
            'experience_years' => $validated['experience_years']
        ]);

        // Dispatch event for the user
        event(new SkillUpdated($skill, $user->id));

        return back()->with('success', 'Skill updated successfully.');
    }

    public function matchUsers(Skill $skill)
    {
        $users = $skill->users()
            ->withPivot('level', 'experience_years')
            ->orderBy('user_skills.level', 'desc')
            ->orderBy('user_skills.experience_years', 'desc')
            ->paginate(20);

        return view('skills.users', compact('skill', 'users'));
    }

    public function matchProjects(Skill $skill)
    {
        $projects = $skill->projects()
            ->with(['owner', 'skills'])
            ->withCount('collaborators')
            ->orderBy('collaborators_count', 'desc')
            ->paginate(20);

        return view('skills.projects', compact('skill', 'projects'));
    }
} 