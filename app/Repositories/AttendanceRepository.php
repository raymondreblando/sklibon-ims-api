<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(User $user, array $data): Attendance;
    public function update(Attendance $attendance, array $data): Attendance;
    public function findForUserAndEvent(string $userId, string $eventId): ?Attendance;
}
