<?php

namespace App\Services\V1;

use App\Http\Resources\V1\NotificationResource;
use App\Models\Notification;
use App\Repositories\Criteria\OrWhere;
use App\Repositories\Criteria\WhereIn;
use App\Repositories\Criteria\WithRelations;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationUserRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class NotificationService
{
    use HasAuthUser;

    public function __construct(
        private NotificationRepository $notificationRepository,
        private NotificationUserRepository $notificationUserRepository
    ){}

    public function get(): JsonResponse
    {
        $criteria = [
            new WhereIn('notifiable_id', [
                $this->getAuthUserId(),
                $this->getAuthUserBarangay()
            ]),
            new OrWhere('type', 'announcement'),
            new WithRelations([
                'notificationUser' => fn (Builder $query) => $query->where('user_id', $this->getAuthUserId())
            ])
        ];

        return Response::success(
            NotificationResource::collection($this->notificationRepository->get($criteria)),
            'Notifications retrieved successfully'
        );
    }

    public function save(array $data, $notifiable = null): Notification
    {
        return $this->notificationRepository->create($data, $notifiable);
    }

    public function update(Notification $notification): JsonResponse
    {
        $this->notificationUserRepository->create($this->user(), [
            'notification_id' => $notification->id,
            'read_at' => now()
        ]);

        return Response::success(
            new NotificationResource($notification),
            'Notification read successfully.'
        );
    }
}
