<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ShortenController;
use App\Http\Controllers\RedirectController;

// Static Pages
Route::inertia('/', 'welcome')->name('home');
Route::inertia('/about', 'about')->name('about');

// Dynamic Pages
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::get('/shorten', [ShortenController::class, 'index'])->name('shorten.index');
Route::post('/shorten', [ShortenController::class, 'store'])->name('shorten.store');

Route::get('/r/{short_url}', [RedirectController::class, 'show'])->name('redirect.show');

// Middleware Required Pages
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
