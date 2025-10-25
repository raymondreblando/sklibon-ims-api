<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\GenerateReportService;
use Illuminate\Http\Request;

class GenerateReportController extends Controller
{
    public function __construct(
        private GenerateReportService $generateReportService
    ){}

    public function attendanceReport(Request $request)
    {
        $queryParams = $request->query();
        return $this->generateReportService->attendanceReport($queryParams);
    }
}
