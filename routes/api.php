<?php

use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;


Route::post('/ask-ai', [AIController::class, 'ask']);

Route::get('/redis-test', function() {
    Cache::put('test-key', 'Hello Redis!', now()->addMinutes(5));
    return Cache::get('test-key');
});