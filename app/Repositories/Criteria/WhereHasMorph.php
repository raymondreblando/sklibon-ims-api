<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WhereHasMorph implements Criteria
{
    public function __construct(
        private $relation,
        private string|array $types,
        private $callback,
        private string $operator = ">=",
        private int $count = 1
    ) {}

    public function apply(Builder $query): void
    {
        $query->whereHasMorph(
            $this->relation,
            $this->types,
            $this->callback,
            $this->operator,
            $this->count
        );
    }
}
