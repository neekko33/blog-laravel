<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CategoriesController;

Route::get('/posts', [PostsController::class, 'apiIndex']);
Route::get('/posts/{id}', [PostsController::class, 'apiShow']);

Route::get('/tags', [TagsController::class, 'apiIndex']);
Route::get('/tags/{id}/posts', [TagsController::class, 'getPostsByTag']);

Route::get('/categories', [CategoriesController::class, 'apiIndex']);
Route::get('/categories/{id}/posts', [CategoriesController::class, 'getPostsByCategory']);

