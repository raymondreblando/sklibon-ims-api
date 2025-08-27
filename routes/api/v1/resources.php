<?php

use App\Http\Controllers\V1\ContactController;
use App\Http\Controllers\V1\HotlineController;
use App\Http\Controllers\V1\ReportController;
use App\Http\Controllers\V1\RequestController;
use App\Http\Controllers\V1\RequestTypeController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resources([
            'contacts' => ContactController::class,
            'hotlines' => HotlineController::class,
            'requests' => RequestController::class,
            'request-types' => RequestTypeController::class,
            'reports' => ReportController::class,
            'users' => UserController::class,
        ]);
    });
});
