<?php

namespace App\Services\V1;

use App\Http\Resources\V1\AttachmentResource;
use App\Models\Attachment;
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
        $payload = $data['attachments'];

        $this->attachmentRepository->createMany($report, $payload);

        return Response::success(
            null,
            'Attachment saved successfully.'
        );
    }

    public function delete(Attachment $attachment): JsonResponse
    {
        $this->attachmentRepository->delete($attachment);

        return Response::success(null, 'Attachment deleted successfully.');
    }
}
