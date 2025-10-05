<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WhereHas implements Criteria
{
    public function __construct(
        private string $relation,
        private $callback
    ){}

    public function apply(Builder $query): void
    {
        $query->whereHas($this->relation, $this->callback);
    }
}
