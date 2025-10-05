<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WhereNot
{
    public function __construct(private string $column, private $value) {}

    public function apply(Builder $query): void
    {
        $query->whereNot($this->column, $this->value);
    }
}
