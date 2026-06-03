<?php

use App\Http\Controllers\Api\V1\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('short-urls', [ShortUrlController::class, 'store']);
    Route::get('short-urls/{id}/stats', [ShortUrlController::class, 'stats'])
        ->whereUuid('id');
});
