<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Where implements Criteria
{
    public function __construct(private string $column, private $value) {}

    public function apply(Builder $query): void
    {
        $query->where($this->column, $this->value);
    }
}
