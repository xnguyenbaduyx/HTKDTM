<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\SupersetTokenController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GeminiController;

Route::get('/', function () {
    return view('layout');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/api/token/login', [DashboardController::class, 'getTokenByLogin'])->name('dashboard.getTokenByLogin');
Route::get('/api/token/guest', [DashboardController::class, 'getTokenByGuest'])->name('dashboard.getTokenByGuest');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/test', [SupersetTokenController::class, 'test']);
Route::get('/search/{query}', [LocationController::class, 'search']);
Route::get('/reverse/{lat}/{lon}', [LocationController::class, 'reverse']);

// Display the Gemini page
Route::get('/gemini', function () {
    return view('pages.gemini');
})->name('gemini');

// Handle the question submission and call the Gemini API
Route::post('/question', [GeminiController::class, 'index']);


