<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserInfo;

interface UserInfoRepository
{
    public function create(User $user, array $data): UserInfo;
    public function update(User $user, array $data): ?UserInfo;
}
