<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TagsController extends Controller
{
    public function index(): Response
    {
        $tags = Tag::all();
        return Inertia::render('Tags', ['tags' => $tags]);
    }

    public function apiIndex(): JsonResponse
    {
        $tags = Tag::withCount('posts')->select('id', 'name')->get();
        return response()->json($tags);
    }

    public function getPostsByTag($id): JsonResponse
    {
        $tag = Tag::find($id);
        $posts = $tag->posts()->select('title', 'description')->paginate(5);
        return response()->json($posts);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        Auth::user()->tags()->create($validated);
        return redirect()->back();
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $tag->update($validated);
        return redirect()->back();
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();
        return redirect()->back();
    }
}
