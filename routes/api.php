<?php

use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;


Route::post('/ask-ai', [AIController::class, 'ask']);