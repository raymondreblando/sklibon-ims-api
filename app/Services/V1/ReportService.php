<?php

namespace App\Services\V1;

use App\Http\Resources\V1\ReportResource;
use App\Models\Report;
use App\Repositories\ReportRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReportService
{
    use HasAuthUser;

    public function __construct(
        private ReportRepository $reportRepository,
        private AttachmentService $attachmentService
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            ReportResource::collection($this->reportRepository->get()),
            'Reports retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $reportPayload = Arr::except($data, ['attachments']);

            $report = $this->reportRepository->create($this->user(), $reportPayload);

            $attachments = $this->attachmentService->attach($report, $data['attachments']);

            return Response::success(
                new ReportResource($report->load('attachments')),
                'Report created successfully.'
            );
        });
    }

    public function find(Report $report): JsonResponse
    {
        $report = $this->reportRepository->find($report);

        return Response::success(
            new ReportResource($report),
            'Report retrieved successfully.'
        );
    }

    public function update(Report $report, array $data): JsonResponse
    {
        $report = $this->reportRepository->update($report, $data);

        return Response::success(
            new ReportResource($report),
            'Report updated successfully.'
        );
    }

    public function delete(Report $report): JsonResponse
    {
        $this->reportRepository->delete($report);

        return Response::success(null, 'Report deleted successfully.');
    }
}
