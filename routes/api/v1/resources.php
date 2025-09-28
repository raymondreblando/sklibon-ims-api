<?php

use App\Http\Controllers\V1\ContactController;
use App\Http\Controllers\V1\EventController;
use App\Http\Controllers\V1\GalleryController;
use App\Http\Controllers\V1\HotlineController;
use App\Http\Controllers\V1\PositionController;
use App\Http\Controllers\V1\ReportController;
use App\Http\Controllers\V1\RequestController;
use App\Http\Controllers\V1\RequestTypeController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resources([
            'requests' => RequestController::class,
            'request-types' => RequestTypeController::class,
            'reports' => ReportController::class,
            'users' => UserController::class,
        ]);

        Route::resource('contacts', ContactController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::resource('positions', PositionController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::resource('events', EventController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::resource('hotlines', HotlineController::class)
            ->only(['store', 'show', 'update']);

        Route::resource('galleries', GalleryController::class)
            ->only(['store', 'update', 'destroy']);
    });
});
