<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Events\RequestCreated;
use App\Services\V1\NotificationService;

class SendNewRequestNotification
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
    public function handle(RequestCreated $event): void
    {
        $request = $event->request;

        $notifyPayload = [
            'type' => 'request',
            'notifiable_id' => $request->receivable_id,
            'notifiable_type' => $request->receivable_type,
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
