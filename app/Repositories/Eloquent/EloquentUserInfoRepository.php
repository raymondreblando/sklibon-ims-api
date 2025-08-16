<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\UserInfo;
use App\Repositories\UserInfoRepository;

class EloquentUserInfoRepository implements UserInfoRepository
{
    public function create(User $user, array $data): UserInfo
    {
        return $user->userInfo()->create($data);
    }

    public function update(User $user, array $data): ?UserInfo
    {
        $userInfo = $user->userInfo;
        $userInfo->update($data);
        return $userInfo;
    }
}
