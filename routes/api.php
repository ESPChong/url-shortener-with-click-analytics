<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\ShortenController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('shorten', [ShortenController::class, 'store'])->name('api.shorten.store');

    Route::get('analytics/{shortUrl}', [AnalyticsController::class, 'show'])->name('api.analytics.show');
});
