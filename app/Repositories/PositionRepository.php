<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepository
{
    public function get(array $relations = []): Collection;
    public function create(array $data): Position;
    public function findById(Position $position, array $relations = []): ?Position;
    public function update(Position $position, array $data): ?Position;
    public function delete(Position $position): bool;
}
