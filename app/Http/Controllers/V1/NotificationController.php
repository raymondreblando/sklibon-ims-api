<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\V1\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->notificationService->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification): JsonResponse
    {
        return $this->notificationService->update($notification);
    }
}
