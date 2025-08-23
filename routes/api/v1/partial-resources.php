<?php

use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\AttachmentController;
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\GalleryController;
use App\Http\Controllers\V1\GalleryImageController;
use App\Http\Controllers\V1\LocationController;
use App\Http\Controllers\V1\NotificationController;
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
        Route::put('/account/change-profile-picture/{id}', [AccountController::class, 'changeProfilePicture']);

        Route::resource('attachments', AttachmentController::class)
            ->only('store', 'destroy');

        Route::resource('gallery-images', GalleryImageController::class)
            ->only('store', 'destroy');

        Route::resource('notifications', NotificationController::class)
            ->only(['index', 'update']);

        Route::controller(GalleryController::class)->group(function () {
            Route::post('/galleries', 'store');
            Route::get('/galleries/{gallery}', 'show');
            Route::put('/galleries/{gallery}', 'update');
            Route::delete('/galleries/{gallery}', 'destroy');
        });

        Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::put('/attendances/{eventId}', [AttendanceController::class, 'attend']);
    });
});
