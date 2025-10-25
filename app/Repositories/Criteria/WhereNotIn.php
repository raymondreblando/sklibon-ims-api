<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WhereNotIn
{
    public function __construct(private string $column, private $value) {}

    public function apply(Builder $query): void
    {
        $query->whereNotIn($this->column, $this->value);
    }
}
