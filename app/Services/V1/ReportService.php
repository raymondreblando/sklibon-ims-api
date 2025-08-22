<?php

namespace App\Services\V1;

use App\Http\Resources\V1\ReportResource;
use App\Models\Report;
use App\Repositories\Criteria\OrWhere;
use App\Repositories\Criteria\Where;
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
        if (! $this->isAdmin()) {
            $criteria = [
                new Where('user_id', $this->user()->id),
                new OrWhere('barangay_id', $this->getAuthUserBarangay())
            ];
        }

        return Response::success(
            ReportResource::collection($this->reportRepository->get($criteria ?? [])),
            'Reports retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $reportPayload = Arr::except($data, ['attachments']);

            $report = $this->reportRepository->create($this->user(), $reportPayload);

            $attachments = $this->attachmentService->save($report, $data['attachments']);

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
}
