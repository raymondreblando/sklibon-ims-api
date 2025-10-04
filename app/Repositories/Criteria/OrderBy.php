<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderBy implements Criteria
{
    public function __construct(
        private string $column,
        private string $direction = 'asc'
    ){}

    public function apply(Builder $query): void
    {
        $query->orderBy($this->column, $this->direction);
    }
}
