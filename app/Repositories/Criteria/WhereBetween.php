<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

class WhereBetween implements Criteria
{
    public function __construct(
        private string|Expression $column,
        private iterable $values,
        private string $boolean = 'and'
    ) {}

    public function apply(Builder $query): void
    {
        $query->whereBetween($this->column, $this->values, $this->boolean);
    }
}
