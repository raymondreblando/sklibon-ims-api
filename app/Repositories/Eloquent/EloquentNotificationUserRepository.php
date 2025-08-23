<?php

namespace App\Repositories\Eloquent;

use App\Models\NotificationUser;
use App\Models\User;
use App\Repositories\NotificationUserRepository;

class EloquentNotificationUserRepository implements NotificationUserRepository
{
    public function create(User $user, array $data): NotificationUser
    {
        return $user->notificationUsers()->create($data);
    }
}
