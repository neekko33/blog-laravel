<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/posts',[PostsController::class, 'index'])->name('posts');
    Route::post('/posts/{post}/publish',[PostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{post}/unpublish',[PostsController::class, 'unpublish'])->name('posts.unpublish');
    Route::get('/posts/create',[PostsController::class, 'create'])->name('posts.create');
    Route::post('/posts',[PostsController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit',[PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}/update',[PostsController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}/destroy',[PostsController::class, 'destroy'])->name('posts.destroy');

    Route::get('/categories',[CategoriesController::class, 'index'])->name('categories');
    Route::post('/categories',[CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}',[CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',[CategoriesController::class, 'destroy'])->name('categories.destroy');

    Route::get('/tags',[TagsController::class, 'index'])->name('tags');
    Route::post('/tags',[TagsController::class, 'store'])->name('tags.store');
    Route::put('/tags/{tag}',[TagsController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}',[TagsController::class, 'destroy'])->name('tags.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
