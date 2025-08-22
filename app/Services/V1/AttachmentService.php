<?php

namespace App\Services\V1;

use App\Models\Report;
use App\Repositories\AttachmentRepository;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class AttachmentService
{
    public function __construct(
        private AttachmentRepository $attachmentRepository
    ){}

    public function save(Report $report, array $data): Collection
    {
        return $this->attachmentRepository->create($report, $data);
    }
}
