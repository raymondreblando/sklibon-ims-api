<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

class GroupBy implements Criteria
{
    public function __construct(
        private string|Expression|array $groups
    ){}

    public function apply(Builder $query): void
    {
        $query->groupBy($this->groups);
    }
}
