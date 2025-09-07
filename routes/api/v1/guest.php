<?php

use App\Http\Controllers\V1\EventController;
use App\Http\Controllers\V1\GalleryController;
use App\Http\Controllers\V1\HotlineController;
use App\Http\Controllers\V1\LocationController;
use App\Http\Controllers\V1\PositionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/hotlines', [HotlineController::class, 'index']);

    Route::prefix('locations')->group(function () {
        Route::controller(LocationController::class)->group(function () {
            Route::get('/provinces', 'getProvinces');
            Route::get('/municipalities/{provinceId?}', 'getMunicipalities');
            Route::get('/barangays/{municipalityId?}', 'getBarangays');
        });
    });
});
