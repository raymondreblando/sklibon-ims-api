<?php

namespace App\Repositories;

use App\Models\NotificationUser;
use App\Models\User;

interface NotificationUserRepository
{
    public function create(User $user, array $data): NotificationUser;
}
