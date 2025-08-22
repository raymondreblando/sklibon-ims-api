<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface Criteria
{
    public function apply(Builder $query): void;
}
