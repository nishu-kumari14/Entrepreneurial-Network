<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Message;
use App\Models\Collaboration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(): View
    {
        $user = auth()->user();
        
        // Get total projects count
        $totalProjects = $user->projects()->count();
        
        // Get active projects count
        $activeProjects = $user->projects()->where('status', 'active')->count();
        
        // Get collaborations count
        $collaborationsCount = $user->collaborations()->where('status', 'active')->count();
        
        // Get skills count
        $skillsCount = $user->skills()->count();
        
        // Get forum posts count
        $forumPosts = $user->forumPosts();
        
        // Get connections count (users who have collaborated on projects)
        $connections = $user->collaboratingProjects()
            ->with('users')
            ->get()
            ->pluck('users')
            ->flatten()
            ->unique('id')
            ->where('id', '!=', $user->id);
        
        // Get recent collaborations
        $recentCollaborations = $user->collaborations()
            ->with('project')
            ->latest()
            ->take(5)
            ->get();
        
        // Get recent projects
        $projects = $user->projects()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Get user skills with count of users who have each skill
        $userSkills = $user->skills()
            ->withCount('users')
            ->get();
        
        return view('dashboard', compact(
            'totalProjects',
            'activeProjects',
            'collaborationsCount',
            'skillsCount',
            'forumPosts',
            'connections',
            'recentCollaborations',
            'userSkills',
            'projects'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $results = [
            'projects' => Project::search($query)
                ->where('status', 'active')
                ->with('user')
                ->get(),
            'users' => User::search($query)
                ->where('id', '!=', Auth::id())
                ->get(),
            'forum_posts' => ForumPost::search($query)
                ->with(['user', 'category'])
                ->get(),
        ];

        return view('dashboard.search', compact('results', 'query'));
    }
}
