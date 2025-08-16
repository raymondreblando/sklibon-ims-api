<?php

namespace App\Repositories\Eloquent;

use App\Models\Position;
use App\Repositories\PositionRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentPositionRepository implements PositionRepository
{
    protected array $relations = [
        'userInfos:id,firstname,middlename,lastname',
        'userInfos.province:id,name',
        'userInfos.municipality:id,name',
        'userInfos.barangay:id,name',
    ];

    public function get(array $relations = []): Collection
    {
        return Position::with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): Position
    {
        return Position::create($data);
    }

    public function findById(string $id, array $relations = []): ?Position
    {
        return Position::with($relations ?: $this->relations)
            ->findOrFail($id);
    }

    public function update(string $id, array $data): ?Position
    {
        $position = Position::findOrFail($id);
        $position->update($data);
        return $position;
    }

    public function delete(string $id): bool
    {
        $position = Position::findOrFail($id);
        return $position->delete();
    }
}
