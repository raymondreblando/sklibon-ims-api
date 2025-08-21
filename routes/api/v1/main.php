<?php

use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\ContactController;
use App\Http\Controllers\V1\HotlineController;
use App\Http\Controllers\V1\LocationController;
use App\Http\Controllers\V1\PositionController;
use App\Http\Controllers\V1\RequestController;
use App\Http\Controllers\V1\RequestTypeController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('locations')->group(function () {
            Route::controller(LocationController::class)->group(function () {
                Route::get('/provinces', 'getProvinces');
                Route::get('/municipalities/{provinceId?}', 'getMunicipalities');
                Route::get('/barangays/{municipalityId?}', 'getBarangays');
            });
        });

        Route::put('/account/change-password/{id}', [AccountController::class, 'changePassword']);
        Route::post('/account/change-profile-picture/{id}', [AccountController::class, 'changeProfilePicture']);

        Route::resources([
            'contacts' => ContactController::class,
            'hotlines' => HotlineController::class,
            'positions' => PositionController::class,
            'requests' => RequestController::class,
            'request-types' => RequestTypeController::class,
            'users' => UserController::class,
        ]);
    });
});
