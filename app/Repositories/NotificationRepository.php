<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepository
{
    public function get(array $criteria = []): Collection;
    public function create(array $data, $notifiable = null): Notification;
}
