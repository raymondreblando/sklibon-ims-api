<?php

use App\Http\Controllers\V1\ChatParticipantController;
use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\AttachmentController;
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\ChatController;
use App\Http\Controllers\V1\GalleryImageController;
use App\Http\Controllers\V1\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::controller(AccountController::class)->group(function () {
            Route::put('/account/change-password', 'changePassword');
            Route::put('/account/change-profile-picture', 'changeProfilePicture');
            Route::put('/account/update-profile', 'updateProfile');
        });

        Route::controller(AttachmentController::class)->group(function () {
            Route::post('/attachments', 'store');
            Route::delete('/attachments/{attachment}', 'destroy');
        });

        Route::controller(GalleryImageController::class)->group(function () {
            Route::post('/gallery-images', 'store');
            Route::delete('/gallery-images/{gallery_image}', 'destroy');
        });

        Route::controller(NotificationController::class)->group(function () {
            Route::get('/notifications', 'index');
            Route::put('/notifications/{gallery_image}', 'update');
        });

        Route::controller(AttendanceController::class)->group(function () {
            Route::get('/attendances', 'index');
            Route::put('/attendances/{eventId}', 'attend');
        });

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
