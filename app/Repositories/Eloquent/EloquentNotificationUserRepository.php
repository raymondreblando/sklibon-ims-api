<?php

namespace App\Repositories\Eloquent;

use App\Models\NotificationUser;
use App\Repositories\NotificationUserRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentNotificationUserRepository implements NotificationUserRepository
{
    protected array $relations = [];

    public function get(): Collection
    {
        return NotificationUser::all()->sortByDesc("primary");
    }

    public function create(array $data): NotificationUser
    {
        return NotificationUser::create($data);
    }

    public function find(NotificationUser $notificationUser): ?NotificationUser
    {
        return $notificationUser;
    }

    public function update(NotificationUser $notificationUser, array $data): ?NotificationUser
    {
        $notificationUser->update($data);
        return $notificationUser;
    }

    public function delete(NotificationUser $notificationUser): bool
    {
        return $notificationUser->delete();
    }
}