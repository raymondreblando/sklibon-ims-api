<?php

namespace App\Repositories\Eloquent;

use App\Models\Position;
use App\Repositories\PositionRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentPositionRepository implements PositionRepository
{
    protected array $relations = [
        'userInfos:id,position_id,firstname,middlename,lastname,province_code,municipality_code,barangay_code',
        'userInfos.province:code,name',
        'userInfos.municipality:code,name',
        'userInfos.barangay:code,name',
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

    public function findById(Position $position, array $relations = []): ?Position
    {
        return $position->load($relations ?: $this->relations);
    }

    public function update(Position $position, array $data): ?Position
    {
        $position->update($data);
        return $position;
    }

    public function delete(Position $position): bool
    {
        return $position->delete();
    }
}
