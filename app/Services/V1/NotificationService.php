<?php

namespace App\Services\V1;

use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class NotificationService
{
    public function __construct(
        private NotificationRepository $notificationRepository
    ){}

    public function save(array $data, $notifiable = null): Notification
    {
        return $this->notificationRepository->create($data, $notifiable);
    }
}
