<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostsController extends Controller
{
    public function index(): Response
    {
        $posts = Auth::user()
            ->posts()
            ->with('tags')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return Inertia::render('Admin/Posts/Posts', ['posts' => $posts]);
    }

    public function apiIndex(): JsonResponse
    {
        $posts = Post::where('published', true)
            ->with('tags')
            ->select('id', 'title', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return response()->json($posts);
    }

    public function apiShow($id): JsonResponse
    {
        $post = Post::find($id);
        $post['tags'] = $post->tags()->get();
        return response()->json($post);
    }

    public function publish(Post $post): RedirectResponse
    {
        $post->update(['published' => true]);
        return redirect()->back();
    }

    public function unpublish(Post $post): RedirectResponse
    {
        $post->update(['published' => false]);
        return redirect()->back();
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Create', ['categories' => Category::all(), 'tags' => Tag::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
           'title' => 'required',
           'description' => 'required',
           'category_id' => 'required',
           'tags_id' => 'required',
           'content' => 'required',
        ]);

        $post = Auth::user()->posts()->create($validated);
        $post->tags()->sync($validated['tags_id']);
        return redirect()->back();
    }

    public function edit(Post $post): Response
    {
        $post['tags'] = $post->tags()->get();
        return Inertia::render('Admin/Posts/Edit', ['post' => $post, 'categories' => Category::all(), 'tags' => Tag::all()]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'tags_id' => 'required',
            'content' => 'required',
        ]);

        $post->update($validated);
        $post->tags()->sync($validated['tags_id']);

        return redirect()->back();
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->back();
    }
}
