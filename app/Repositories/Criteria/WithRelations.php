<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WithRelations implements Criteria
{
    public function __construct(protected array $relations) {}

    public function apply(Builder $query): void
    {
        $query->with($this->relations);
    }
}
