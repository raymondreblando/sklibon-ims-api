<?php

use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\HotlineController;
use App\Http\Controllers\V1\LocationController;
use App\Http\Controllers\V1\PositionController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('locations')->group(function () {
            Route::controller(LocationController::class)->group(function () {
                Route::get('/provinces', 'getProvinces');
                Route::get('/municipalities/{provinceCode?}', 'getMunicipalities');
                Route::get('/barangays/{municipalityCode?}', 'getBarangays');
            });
        });

        Route::put('/account/change-password/{id}', [AccountController::class, 'changePassword']);
        Route::post('/account/change-profile-picture/{id}', [AccountController::class, 'changeProfilePicture']);

        Route::resources([
            'users' => UserController::class,
            'positions' => PositionController::class,
            'hotlines' => HotlineController::class
        ]);
    });
});
