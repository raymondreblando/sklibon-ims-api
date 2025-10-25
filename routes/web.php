<?php

use App\Services\V1\GenerateReportService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): JsonResponse {
    return Response::error('Not Found', 404);
});

// Route::get('/', function (GenerateReportService $generateReportService) {
//     $queryParams = ['event_id' => null, 'with_time' => true];
//     return $generateReportService->attendanceReport($queryParams);
// });
