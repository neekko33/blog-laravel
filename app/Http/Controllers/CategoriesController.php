<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class CategoriesController extends Controller
{
    public function index(): Response
    {
        $categories = Category::all();
        return Inertia::render('Categories', ['categories' => $categories]);
    }
}
