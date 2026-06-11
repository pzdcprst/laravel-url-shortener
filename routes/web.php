<?php

use App\Http\Controllers\Api\V1\ShortUrlController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/', 'dashboard');

    Route::delete(
        '/short-urls/{id}',
        [ShortUrlController::class, 'destroy']
    );

    Route::prefix('api/v1')->group(function () {
        Route::post('short-urls', [ShortUrlController::class, 'store']);
        Route::get('short-urls/{id}/stats', [ShortUrlController::class, 'stats'])
            ->whereUuid('id');
    });
});

Route::get('/{shortCode}', RedirectController::class)
    ->where('shortCode', '[0-9a-zA-Z]{6,8}');
