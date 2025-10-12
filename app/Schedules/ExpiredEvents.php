<?php

namespace App\Schedules;

use App\Enums\EventStatus;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpiredEvents
{
    public function __invoke(): void
    {
        DB::transaction(function () {
            Event::where('expired_date', '<', Carbon::now()->subMinutes(20))
                ->whereNot('status', EventStatus::Archived->value)
                ->update(['status' => EventStatus::Completed->value]);
        });
    }
}
