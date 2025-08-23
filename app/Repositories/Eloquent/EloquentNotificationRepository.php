<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentNotificationRepository implements NotificationRepository
{
    public function get(array $criteria = []): Collection
    {
        $query = Notification::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->orderBy('id', 'desc')
            ->get(['id', 'type', 'data']);
    }

    public function create(array $data, $notifiable = null): Notification
    {
        if ($notifiable)
            return $notifiable->notifications()->create($data);

        return Notification::create($data);
    }

    public function update(Notification $notification, array $data): Notification
    {
        $notification->update($data);
        return $notification;
    }
}
