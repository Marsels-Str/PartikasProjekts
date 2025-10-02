<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\RegisteredUserController;

//Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Welcome
Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth'])->name('welcome');

//Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Products
Route::middleware('auth')->group(function () {
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('/history', [ProductController::class, 'history'])->name('history');
    Route::get('/search-product', [ProductController::class, 'search'])->name('searchProduct');
    Route::post('/translate-product', [ProductController::class, 'translateProduct'])->name('translateProduct');
});

require __DIR__.'/auth.php';
