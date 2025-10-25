<?php

namespace App\Services\V1;

use App\Repositories\Criteria\HasRelation;
use App\Repositories\Criteria\Where;
use App\Repositories\EventRepository;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReportService
{
    public function __construct(
        private EventRepository $eventRepository
    ){}

    public function attendanceReport(array|string|null $queryParams)
    {
        $eventId = $queryParams['event_id'] ?? null;
        $withTime = filter_var($queryParams['with_time'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $relations = [
            'attendances',
            'attendances.user.userInfo:id,user_id,position_id,barangay_id,firstname,lastname',
            'attendances.user.userInfo.position:id,name',
            'attendances.user.userInfo.barangay:id,name'
        ];

        $criteria = [
            new HasRelation('attendances')
        ];

        if (! empty($eventId))
            $criteria[] = new Where('id', $eventId);

        $events = $this->eventRepository->get($criteria, $relations);

        $attachment = Pdf::loadView('attendance-report', [
            'datas' => $events,
            'withTime' => $withTime
        ]);

        return response($attachment->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="attendance.pdf"');
    }
}
