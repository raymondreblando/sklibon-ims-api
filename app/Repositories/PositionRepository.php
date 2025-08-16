<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepository
{
    public function get(array $relations = []): Collection;
    public function create(array $data): Position;
    public function findById(string $id, array $relations = []): ?Position;
    public function update(string $id, array $data): ?Position;
    public function delete(string $id): bool;
}
