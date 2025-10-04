<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class SelectRaw implements Criteria
{
    public function __construct(
        private string $expression,
        private array $bindings = []
    ){}

    public function apply(Builder $query): void
    {
        $query->selectRaw($this->expression, $this->bindings);
    }
}
