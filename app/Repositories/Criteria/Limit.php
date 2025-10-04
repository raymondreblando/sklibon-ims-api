<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Limit
{
    public function __construct(private int $limit){}

    public function apply(Builder $query): void
    {
        $query->limit($this->limit);
    }
}
