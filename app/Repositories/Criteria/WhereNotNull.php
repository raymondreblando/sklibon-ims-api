<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

class WhereNotNull implements Criteria
{
    public function __construct(
        private string|array|Expression $columns,
        private string $boolean = 'and'
    ) {}

    public function apply(Builder $query): void
    {
        $query->whereNotNull($this->columns, $this->boolean);
    }
}
