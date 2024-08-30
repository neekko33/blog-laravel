<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
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
    Route::post('/posts/{post}/updateImgUrl',[PostsController::class, 'updateImgUrl'])->name('posts.updateImgUrl');
    Route::get('/posts/{post}/edit',[PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}/update',[PostsController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}/destroy',[PostsController::class, 'destroy'])->name('posts.destroy');

    Route::get('/categories',[CategoriesController::class, 'index'])->name('categories');
});

Route::get('/tags', function () {
    return 'Tags';
})->middleware(['auth', 'verified'])->name('tags');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
