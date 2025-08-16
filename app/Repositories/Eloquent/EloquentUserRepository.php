<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository implements UserRepository
{
    private array $relations = [
        'role:id,role',
        'userInfo',
        'userInfo.position:id,name',
        'userInfo.province:code,name',
        'userInfo.municipality:code,name',
        'userInfo.barangay:code,name',
    ];

    public function get(array $relations = []): Collection
    {
        return User::with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(User $user, array $relations = []): ?User
    {
        return $user->load($relations ?: $this->relations);
    }

    public function update(User $user, array $data): ?User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
