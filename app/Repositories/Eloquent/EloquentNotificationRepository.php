<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentNotificationRepository implements NotificationRepository
{
    protected array $relations = [];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        return Notification::all()->sortByDesc("primary");
    }

    public function create(array $data, $notifiable = null): Notification
    {
        if ($notifiable)
            return $notifiable->notifications()->create($data);

        return Notification::create($data);
    }

    public function find(Notification $notification): ?Notification
    {
        return $notification;
    }

    public function update(Notification $notification, array $data): ?Notification
    {
        $notification->update($data);
        return $notification;
    }

    public function delete(Notification $notification): bool
    {
        return $notification->delete();
    }
}
