<?php

use App\Http\Controllers\V1\GalleryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
});
