<?php

namespace App\Repositories\Eloquent;

use App\Models\Hotline;
use App\Repositories\HotlineRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentHotlineRepository implements HotlineRepository
{
    public function get(): Collection
    {
        return Hotline::orderBy('id', 'desc')->get();
    }

    public function create(array $data): Hotline
    {
        return Hotline::create($data);
    }

    public function update(Hotline $hotline, array $data): ?Hotline
    {
        $hotline->update($data);
        return $hotline;
    }
}
