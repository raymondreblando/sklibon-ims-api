<?php

namespace App\Repositories;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Collection;

interface ArchiveRepository
{
    public function get(array $relations = []): Collection;
    public function delete(Archive $archive): bool;
}
