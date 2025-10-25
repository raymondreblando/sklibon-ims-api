<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class HasRelation implements Criteria
{
    public function __construct(
        private string $relation,
        private string $operator = '>=',
        private int $count = 1,
        private string $boolean = 'and',
        private $callback = null
    ){}

    public function apply(Builder $query): void
    {
        $query->has(
            $this->relation,
            $this->operator,
            $this->count,
            $this->boolean,
            $this->callback
        );
    }
}
