<?php

namespace App\Services\V1;

use App\Http\Resources\V1\ReportResource;
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
}
