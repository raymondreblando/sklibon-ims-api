<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentAttendanceRepository implements AttendanceRepository
{
    protected array $relations = [
        'event'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = Attendance::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->get();
    }

    public function create(User $user, array $data): Attendance
    {
        return $user->attendances()->create($data);
    }

    public function update(Attendance $attendance, array $data): Attendance
    {
        $attendance->update($data);
        return $attendance;
    }

    public function findForUserAndEvent(string $userId, string $eventId): ?Attendance
    {
        return Attendance::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();
    }
}
