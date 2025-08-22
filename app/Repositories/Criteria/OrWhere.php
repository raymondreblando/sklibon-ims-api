<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class OrWhere implements Criteria
{
    public function __construct(private string $column, private $value) {}

    public function apply(Builder $query): void
    {
        $query->orWhere($this->column, $this->value);
    }
}
