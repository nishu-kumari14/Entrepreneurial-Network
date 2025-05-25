<?php

namespace App\Http\Controllers;

use App\Events\DocumentUpdated;
use App\Models\DocumentCollaboration;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentCollaborationController extends Controller
{
    public function index(Project $project)
    {
        $documents = $project->documents()->latest()->paginate(10);
        return view('documents.index', compact('project', 'documents'));
    }

    public function create(Project $project)
    {
        return view('documents.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:document,code,diagram',
        ]);

        $document = $project->documents()->create($validated);
        
        broadcast(new DocumentUpdated($document, Auth::user(), 'created'))->toOthers();

        return redirect()->route('projects.documents.show', [$project, $document])
            ->with('success', 'Document created successfully.');
    }

    public function show(Project $project, DocumentCollaboration $document)
    {
        $document->addEditor(Auth::user());
        return view('documents.show', compact('project', 'document'));
    }

    public function update(Request $request, Project $project, DocumentCollaboration $document)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $document->update($validated);
        $document->addEditHistory(Auth::user(), 'updated');
        
        broadcast(new DocumentUpdated($document, Auth::user(), 'updated', $validated['content']))->toOthers();

        return response()->json(['message' => 'Document updated successfully']);
    }

    public function destroy(Project $project, DocumentCollaboration $document)
    {
        $document->delete();
        broadcast(new DocumentUpdated($document, Auth::user(), 'deleted'))->toOthers();

        return redirect()->route('projects.documents.index', $project)
            ->with('success', 'Document deleted successfully.');
    }

    public function removeEditor(Project $project, DocumentCollaboration $document)
    {
        $document->removeEditor(Auth::user());
        broadcast(new DocumentUpdated($document, Auth::user(), 'left'))->toOthers();

        return response()->json(['message' => 'Editor removed successfully']);
    }
} 