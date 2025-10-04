<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(array $data): User;
    public function find(User $user, array $relations = []): ?User;
    public function findById(string $id, array $relations = []): ?User;
    public function update(User $user, array $data): ?User;
    public function delete(User $user): bool;
}
