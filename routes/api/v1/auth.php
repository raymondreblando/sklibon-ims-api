<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\RefreshTokenController;
use App\Http\Middleware\EnsureRefreshTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');

    Route::post('/refresh-token', RefreshTokenController::class)
        ->middleware(EnsureRefreshTokenIsValid::class);
});

