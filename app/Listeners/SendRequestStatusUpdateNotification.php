<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Events\RequestStatusUpdated;
use App\Services\V1\NotificationService;

class SendRequestStatusUpdateNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public NotificationService $notificationService
    ){}

    /**
     * Handle the event.
     */
    public function handle(RequestStatusUpdated $event): void
    {
        $request = $event->request;

        $notifyPayload = [
            'type' => 'request',
            'notifiable_id' => $request->user_id,
            'notifiable_type' => 'App\Models\User',
            'data' => [
                'requestId' => $request->id,
                'user' => $event->userName,
                'request' => $request->name,
                'status' => $request->status
            ],
        ];

        $notification = $this->notificationService->save($notifyPayload);

        if ($notification) {
            NotificationCreated::dispatch($notification);
        }
    }
}
