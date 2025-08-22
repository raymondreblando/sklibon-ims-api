<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WhereIn implements Criteria
{
    public function __construct(private string $column, private array $values) {}

    public function apply(Builder $query): void
    {
        $query->whereIn($this->column, $this->values);
    }
}
