<?php

use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\PositionController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::put('/account/change-password/{id}', [AccountController::class, 'changePassword']);

        Route::resources([
            'users' => UserController::class,
            'positions' => PositionController::class
        ]);
    });
});
