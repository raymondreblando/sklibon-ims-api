<?php

namespace App\Repositories;

use App\Models\Hotline;
use Illuminate\Database\Eloquent\Collection;

interface HotlineRepository
{
    public function get(): Collection;
    public function create(array $data): Hotline;
    public function update(Hotline $hotline, array $data): ?Hotline;
}
