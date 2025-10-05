<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;

interface UserRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function getSummary(string $key, string $value, array $criteria = []): CollectionSupport;
    public function create(array $data): User;
    public function find(User $user, array $relations = []): ?User;
    public function findById(string $id, array $relations = []): ?User;
    public function update(User $user, array $data): ?User;
    public function delete(User $user): bool;
}
