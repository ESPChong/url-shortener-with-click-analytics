<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SimpleFaqController;

// Static Pages
Route::inertia('/v1', 'welcome')->name('home');
Route::inertia('/v1/about', 'about')->name('about');

// Dynamic Pages
Route::get('/v1/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/v1/simplefaq', [SimpleFaqController::class, 'index'])->name('simplefaq.index');

// Middleware Required Pages
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
