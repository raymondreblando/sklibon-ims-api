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
        'userInfo.province:id,name',
        'userInfo.municipality:id,name',
        'userInfo.barangay:id,name',
    ];

    public function get(string $userId, array $relations = []): Collection
    {
        return User::with($relations ?: $this->relations)
            ->whereNot('id', $userId)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function find(User $user, array $relations = []): ?User
    {
        return $user->load($relations ?: $this->relations);
    }

    public function findById(string $id, array $relations = []): ?User
    {
        return User::with($relations ?: $this->relations)
            ->findOrFail($id);
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
