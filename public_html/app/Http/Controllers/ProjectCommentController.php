<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectCommentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $project->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Project $project, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
} 