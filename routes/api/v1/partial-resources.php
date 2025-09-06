<?php

use App\Http\Controllers\V1\ChatParticipantController;
use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\AttachmentController;
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\ChatController;
use App\Http\Controllers\V1\EventController;
use App\Http\Controllers\V1\GalleryController;
use App\Http\Controllers\V1\GalleryImageController;
use App\Http\Controllers\V1\NotificationController;
use App\Http\Controllers\V1\PositionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::put('/account/change-password', [AccountController::class, 'changePassword']);
        Route::put('/account/change-profile-picture/{id}', [AccountController::class, 'changeProfilePicture']);
        Route::put('/account/update-profile', [AccountController::class, 'updateProfile']);

        Route::resource('attachments', AttachmentController::class)
            ->only('store', 'destroy');

        Route::resource('gallery-images', GalleryImageController::class)
            ->only('store', 'destroy');

        Route::resource('notifications', NotificationController::class)
            ->only(['index', 'update']);

        Route::resource('positions', PositionController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::resource('events', EventController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::resource('galleries', GalleryController::class)
            ->only(['store', 'show', 'update', 'destroy']);

        Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::put('/attendances/{eventId}', [AttendanceController::class, 'attend']);

        Route::controller(ChatController::class)->group(function () {
            Route::get('/chats', 'index');
            Route::post('/chat/privates', 'storePrivateChat');
            Route::post('/chat/group-chats', 'storeGroupChat');
            Route::put('/chats/{chat}', 'send');
        });

        Route::controller(ChatParticipantController::class)->group(function () {
            Route::get('/chat/participants', 'index');
            Route::post('/chat/participants', 'store');
            Route::delete('/chat/participants/{id}', 'destroy');
        });
    });
});
