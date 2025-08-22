<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(array $data, $notifiable = null): Notification;
    public function find(Notification $notification): ?Notification;
    public function update(Notification $notification, array $data): ?Notification;
    public function delete(Notification $notification): bool;
}
