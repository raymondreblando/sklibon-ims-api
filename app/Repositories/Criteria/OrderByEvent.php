<?php

namespace App\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderByEvent implements Criteria
{
    public function apply(Builder $query): void
    {
        $query->join('events', 'attendances.event_id', '=', 'events.id')
            ->orderBy('events.event_date', 'desc')
            ->orderBy('attendances.id', 'desc')
            ->select('attendances.*');
    }
}
