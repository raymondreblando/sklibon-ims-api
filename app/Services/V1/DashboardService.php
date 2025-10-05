<?php

namespace App\Services\V1;

use App\Enums\EventStatus;
use App\Enums\UserStatus;
use App\Http\Resources\V1\AttendanceResource;
use App\Http\Resources\V1\EventResource;
use App\Repositories\AttendanceRepository;
use App\Repositories\Criteria\GroupBy;
use App\Repositories\Criteria\Limit;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\SelectRaw;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WhereNot;
use App\Repositories\Criteria\WhereNotNull;
use App\Repositories\EventRepository;
use App\Repositories\RequestRepository;
use App\Repositories\UserRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    use HasAuthUser;

    public function __construct(
        private RequestRepository $requestRepository,
        private EventRepository $eventRepository,
        private AttendanceRepository $attendanceRepository,
        private UserRepository $userRepository,
    ){}

    public function get(): JsonResponse
    {
        $statistics = [
            'overviews' => $this->getRequestOverviewCount(),
            'upcomingEvents' => $this->getUpcomingEvents(),
            'requestStatistics' => $this->getRequestStatistics(),
            'memberStatistics' => $this->getMemberStatistics(),
            'attendanceStatistics' => $this->getAttendanceStatistics(),
            'attendanceLogs' => $this->getAttendanceLogs(),
        ];

        return Response::success(
            $statistics,
            "Dashboard summary retrieved successfully."
        );
    }

    protected function getRequestOverviewCount(): array
    {
        $criteria = [
            new SelectRaw('status, COUNT(*) as total')
        ];

        if (! $this->isAdmin()) {
            $criteria[] = new Where('user_id', $this->getAuthUserId());
        }

        $criteria[] = new GroupBy('status');

        $summary = $this->requestRepository->getSummary('status', 'total', $criteria);

        return [
            'pending' => $summary['pending'] ?? 0,
            'approved' => $summary['approved'] ?? 0,
            'completed' => $summary['completed'] ?? 0,
            'cancelled' => $summary['cancelled'] ?? 0,
        ];
    }

    protected function getUpcomingEvents(): AnonymousResourceCollection
    {
        $currentDate = now()->format('Y-m-d h:i:s');

        $criteria = [
            new WhereNot('status', EventStatus::Archived->value),
            new Where('event_date', $currentDate, '>'),
            new OrderBy('event_date'),
            new Limit(5)
        ];

        return EventResource::collection($this->eventRepository->get($criteria));
    }

    protected function getRequestStatistics(): Collection
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        $prevYear = $currentYear - 1;

        $selectRaw = 'DATE(created_at) as date, COUNT(*) as total';
        $groupBy = DB::raw('DATE(created_at)');
        $key = 'date';
        $value = 'total';

        $startDate = $now->copy()->subMonths(2)->startOfMonth();
        $endDate = $now->copy()->endOfMonth();

        $currentCriteria = [
            new SelectRaw($selectRaw),
            new WhereBetween('created_at', [$startDate, $endDate]),
            new GroupBy($groupBy)
        ];

        $current = $this->requestRepository->getSummary($key, $value, $currentCriteria);

        $prevStart = $startDate->copy()->subYear();
        $prevEnd = $endDate->copy()->subYear();

        $prevCriteria = [
            new SelectRaw($selectRaw),
            new WhereBetween('created_at', [$prevStart, $prevEnd]),
            new GroupBy($groupBy)
        ];

        $prev = $this->requestRepository->getSummary($key, $value, $prevCriteria);

        $months = collect([
            $startDate->copy()->toDateString(),
            $startDate->copy()->addMonth()->toDateString(),
            $startDate->copy()->addMonths(2)->toDateString(),
        ]);

        $dates = collect();
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate->copy()->addDay()
        );

        foreach ($period as $date) {
            $carbonDate = Carbon::instance($date);

            $formatted = $carbonDate->format('Y-m-d');
            $prevFormatted = $carbonDate->copy()->subYear()->format('Y-m-d');

            $dates->push([
                'date' => $formatted,
                'current' => $current[$formatted] ?? 0,
                'prev' => $prev[$prevFormatted] ?? 0,
            ]);
        }

        return $dates->values();
    }

    protected function getMemberStatistics(): array
    {
        $criteria = [
            new SelectRaw('status, COUNT(*) as total'),
            new GroupBy('status')
        ];

        $summary = $this->userRepository->getSummary('status', 'total', $criteria);

        return collect($summary)->map(function (int $total, string $key) {
            return [
                'status' => $key,
                'total' => $total,
                'fill' => $this->getFillColor($key)
            ];
        })
        ->values()
        ->toArray();
    }

    protected function getAttendanceStatistics(): Collection
    {
        $criteria = [
            new SelectRaw('COUNT(*) as total'),
            new Where('status', UserStatus::Verified->value)
        ];

        $totalAttendance = 0;
        $totalMembers = (int) $this->userRepository->get($criteria)->value('total');

        $criteria = [
            new Where('expired_date', now()->format('Y-m-d h:i:s'), '<'),
            new OrderBy('expired_date', 'desc'),
            new Limit(1)
        ];

        $event = $this->eventRepository->get($criteria)->first();

        if ($event) {
            $criteria = [
                new SelectRaw('COUNT(*) as total'),
                new Where('event_id', $event->id),
                new WhereNotNull(['time_in', 'time_out'])
            ];

            $totalAttendance = (int) $this->attendanceRepository->get($criteria)->value('total');
        }

        return collect([
            [
                'status' => 'Attendees',
                'total' => $totalAttendance,
                'fill' => $this->getFillColor('joined')
            ],
            [
                'status' => 'Absentees',
                'total' => $totalMembers - $totalAttendance,
                'fill' => $this->getFillColor('missing')
            ]
        ]);
    }

    protected function getAttendanceLogs(): AnonymousResourceCollection
    {
        $criteria = [];

        if (! $this->isAdmin()) {
            $criteria[] = new Where('user_id', $this->getAuthUserId());
        }

        $criteria = array_merge($criteria, [
            new OrderBy('id', 'desc'),
            new Limit(4)
        ]);

        return AttendanceResource::collection($this->attendanceRepository->get($criteria));
    }

    protected function getFillColor(string $key): string
    {
        $fills = [
            'active' => 'var(--color-active)',
            'verified' => 'var(--color-verified)',
            'deactivated' => 'var(--color-deactivated)',
            'blocked' => 'var(--color-blocked)',
            'joined' => 'oklch(62.3% 0.214 259.815)',
            'missing' => 'oklch(71.2% 0.194 13.428)'
        ];

        return $fills[$key];
    }
}
