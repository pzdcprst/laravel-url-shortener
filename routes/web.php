<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard');

Route::get('/{shortCode}', RedirectController::class)
    ->where('shortCode', '[0-9a-zA-Z]{6,8}');
