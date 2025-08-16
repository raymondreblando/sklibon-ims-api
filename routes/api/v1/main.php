<?php

use App\Http\Controllers\V1\PositionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resources([
            'positions' => PositionController::class
        ]);
    });
});
