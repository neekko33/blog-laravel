<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CategoriesController extends Controller
{
    public function index(): Response
    {
        $categories = Category::all();
        return Inertia::render('Categories', ['categories' => $categories]);
    }

    public function apiIndex(): JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getPostsByCategory($id): JsonResponse
    {
        $category = Category::find($id);
        $posts = $category->posts()->select('title', 'description')->paginate(5);
        return response()->json($posts);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        Auth::user()->categories()->create($validated);
        return redirect()->back();
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $category->update($validated);
        return redirect()->back();
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->back();
    }
}
