<?php

namespace App\Repositories;

use App\Models\NotificationUser;
use Illuminate\Database\Eloquent\Collection;

interface NotificationUserRepository
{
    public function get(): Collection;
    public function create(array $data): NotificationUser;
    public function find(NotificationUser $notificationUser): ?NotificationUser;
    public function update(NotificationUser $notificationUser, array $data): ?NotificationUser;
    public function delete(NotificationUser $notificationUser): bool;
}