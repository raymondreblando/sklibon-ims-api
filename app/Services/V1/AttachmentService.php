<?php

namespace App\Services\V1;

use App\Http\Resources\V1\AttachmentResource;
use App\Models\Report;
use App\Repositories\AttachmentRepository;
use App\Repositories\ReportRepository;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class AttachmentService
{
    public function __construct(
        private AttachmentRepository $attachmentRepository,
        private ReportRepository $reportRepository
    ){}

    public function attach(Report $report, array $data): Collection
    {
        return $this->attachmentRepository->createMany($report, $data);
    }

    public function save(array $data): JsonResponse
    {
        $report = $this->reportRepository->findById($data['report_id']);
        $payload = Arr::except($data, ['report_id']);

        $attachment = $this->attachmentRepository->create($report, $payload);

        return Response::success(
            new AttachmentResource($attachment),
            'Attachment saved successfully.'
        );
    }
}
