<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
