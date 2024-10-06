<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use Inertia\Response;

class TagsController extends Controller
{
    public function index(): Response
    {
        $tags = Tag::all();
        return Inertia::render('Tags', ['tags' => $tags]);
    }
}
