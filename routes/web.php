<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard_new');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/ask-ai', [AIController::class, 'ask']);
    Route::get('/ai-history', [AIController::class, 'getHistory']);
    Route::get('/ai-suggestions', [AIController::class, 'getSuggestions']);
});



require __DIR__.'/auth.php';
