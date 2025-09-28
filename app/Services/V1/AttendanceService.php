<?php

namespace App\Services\V1;

use App\Http\Resources\V1\AttendanceResource;
use App\Repositories\AttendanceRepository;
use App\Repositories\Criteria\Where;
use App\Repositories\EventRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class AttendanceService
{
    use HasAuthUser;

    public function __construct(
        private AttendanceRepository $attendanceRepository,
        private EventRepository $eventRepository
    ) {}

    public function get(): JsonResponse
    {
        $criteria = [];

        if (! $this->isAdmin())
            $criteria[] = new Where('user_id', $this->getAuthUserId());

        $attendances = $this->attendanceRepository->get($criteria);

        return Response::success(
            AttendanceResource::collection($attendances),
            'Attendances retrieved successfully.'
        );
    }

    public function save(string $eventId): JsonResponse
    {
        $event = $this->eventRepository->findById($eventId);

        if (now()->lt($event->event_date)) {
            return Response::error('Attendance for this event has not opened yet.');
        }

        if (! $event->open_attendance) {
            return Response::error('Attendance for this event is now closed.');
        }

        $attendance = $this->attendanceRepository->findForUserAndEvent($this->getAuthUserId(), $event->id);

        if ($attendance && ! $attendance->time_out) {
            if ($event->expired_date && now()->lt($event->expired_date->subMinutes(15))) {
                return Response::error('You’ve already checked in for this event.');
            }
        }

        if ($attendance && $attendance->time_out) {
            return Response::error('You have already timed out for this event.');
        }

        if (! $attendance) {
            $payload = ['event_id' => $event->id, 'time_in' => now()];
            $newAttendance = $this->attendanceRepository->create($this->user(), $payload);
            $action = 'time-in';
        } else {
            $payload = ['time_out' => now()];
            $newAttendance = $this->attendanceRepository->update($attendance, $payload);
            $action = 'time-out';
        }

        return Response::success(
            new AttendanceResource($newAttendance),
            "Your {$action} has been recorded successfully."
        );
    }
}
