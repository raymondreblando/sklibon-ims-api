<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Report\StoreReportRequest;
use App\Models\Report;
use App\Services\V1\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Report::class);

        return $this->reportService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        Gate::authorize('create', Report::class);

        $data = $request->validated();
        return $this->reportService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report): JsonResponse
    {
        Gate::authorize('view', $report);

        return $this->reportService->find($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
