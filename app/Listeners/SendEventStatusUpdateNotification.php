<?php

namespace App\Listeners;

use App\Events\EventStatusUpdated;
use App\Events\NotificationCreated;
use App\Services\V1\NotificationService;

class SendEventStatusUpdateNotification
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
    public function handle(EventStatusUpdated $event): void
    {
        $skEvent = $event->event;

        $notifyPayload = [
            'type' => 'announcement',
            'notifiable_id' => $skEvent->id,
            'notifiable_type' => 'App\Models\Event',
            'data' => [
                'eventId' => $skEvent->id,
                'eventName' => $skEvent->name,
                'status' => $skEvent->status
            ],
        ];

        $notification = $this->notificationService->save($notifyPayload);

        if ($notification) {
            NotificationCreated::dispatch($notification);
        }
    }
}
