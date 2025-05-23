<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\ForumLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ForumCategory::withCount('posts')->get();
        $latestPosts = ForumPost::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('forum.index', compact('categories', 'latestPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ForumCategory::all();
        return view('forum.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $post = auth()->user()->forumPosts()->create($validated);

        return redirect()->route('forum.show', $post)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ForumPost $post)
    {
        $post->increment('views');
        $post->load(['user', 'comments.user']);

        return view('forum.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumPost $post)
    {
        $this->authorize('update', $post);
        $categories = ForumCategory::orderBy('name')->get();

        return view('forum.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumPost $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:forum_categories,id',
            'content' => 'required|string',
        ]);

        $post->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
        ]);

        return redirect()->route('forum.show', $post)
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumPost $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('forum.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function comment(Request $request, ForumPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:forum_comments,id'
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        return redirect()->route('forum.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    public function like(ForumPost $post)
    {
        $user = Auth::user();

        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user);
            $message = 'Post unliked successfully.';
        } else {
            $post->likes()->attach($user);
            $message = 'Post liked successfully.';
        }

        return back()->with('success', $message);
    }

    public function showCategory(ForumCategory $category)
    {
        $posts = $category->posts()
            ->with('user', 'comments')
            ->latest()
            ->paginate(20);

        return view('forum.category', compact('category', 'posts'));
    }

    public function showPost(ForumPost $post)
    {
        $post->incrementViews();
        $post->load('user', 'category', 'comments');

        return view('forum.show', compact('post'));
    }

    public function storeComment(Request $request, ForumPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function likePost(ForumPost $post)
    {
        if ($post->isLikedBy(Auth::user())) {
            $post->likes()->where('user_id', Auth::id())->delete();
            return back()->with('success', 'Post unliked successfully.');
        }

        $post->likes()->create(['user_id' => Auth::id()]);
        return back()->with('success', 'Post liked successfully.');
    }

    public function likeComment(ForumComment $comment)
    {
        if ($comment->isLikedBy(Auth::user())) {
            $comment->likes()->where('user_id', Auth::id())->delete();
            return back()->with('success', 'Comment unliked successfully.');
        }

        $comment->likes()->create(['user_id' => Auth::id()]);
        return back()->with('success', 'Comment liked successfully.');
    }

    public function category(ForumCategory $category)
    {
        $posts = ForumPost::where('category_id', $category->id)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);

        $categories = ForumCategory::withCount('posts')->get();

        return view('forum.index', [
            'categories' => $categories,
            'latestPosts' => $posts,
            'currentCategory' => $category
        ]);
    }

    public function destroyComment(ForumPost $post, ForumComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
