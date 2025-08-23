<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\AttendanceService;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService
    ){}

    public function attend(string $eventId): JsonResponse
    {
        return $this->attendanceService->save($eventId);
    }
}
