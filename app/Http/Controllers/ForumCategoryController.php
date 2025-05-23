<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(ForumCategory::class, 'category');
    }

    public function index()
    {
        $categories = ForumCategory::orderBy('order')->get();
        return view('forum.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('forum.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0'
        ]);

        $category = ForumCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'order' => $validated['order']
        ]);

        return redirect()->route('forum.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(ForumCategory $category)
    {
        return view('forum.categories.edit', compact('category'));
    }

    public function update(Request $request, ForumCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0'
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'order' => $validated['order']
        ]);

        return redirect()->route('forum.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(ForumCategory $category)
    {
        $category->delete();
        return redirect()->route('forum.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
} 