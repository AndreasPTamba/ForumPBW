<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    Route::resource('posts', PostController::class)->middleware('auth');
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::post('/posts/{post}/share', [ShareController::class, 'store'])->name('posts.share');
    // Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/reply', [PostController::class, 'reply'])->name('posts.reply');
require __DIR__.'/auth.php';
