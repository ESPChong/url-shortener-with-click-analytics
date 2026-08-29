<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ShortenController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\DashboardController;

// Static Pages
Route::inertia('/', 'welcome')->name('home');
Route::inertia('about', 'about')->name('about');

// Dynamic Pages
Route::get('faq', [FaqController::class, 'index'])->name('faq.index');

// Dashboard
Route::get('dash', [DashboardController::class, 'index'])->name('dash.index');

// Shortener
Route::get('shorten', [ShortenController::class, 'index'])->name('shorten.index');
Route::post('shorten', [ShortenController::class, 'store'])->name('shorten.store');

// Redirecter
Route::get('r/{short_url}', [RedirectController::class, 'show'])->name('redirect.show');

// Middleware Required Pages
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});


require __DIR__.'/settings.php';
