<?php

namespace App\Repositories\Eloquent;

use App\Models\Archive;
use App\Repositories\ArchiveRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentArchiveRepository implements ArchiveRepository
{
    protected array $relations = [
        'user:id,profile',
        'user.userInfo:id,user_id,position_id,firstname,lastname',
        'user.userInfo.position:id,name',
    ];

    public function get(array $relations = []): Collection
    {
        return Archive::with($relations ?: $this->relations)
            ->withArchivable()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function delete(Archive $archive): bool
    {
        return $archive->delete();
    }
}
