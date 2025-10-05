<?php

namespace App\Services\V1;

use App\Enums\EventStatus;
use App\Enums\ReportStatus;
use App\Http\Resources\V1\ArchiveResource;
use App\Models\Archive;
use App\Models\Event;
use App\Repositories\ArchiveRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ArchiveService
{
    public function __construct(
        private ArchiveRepository $archiveRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            ArchiveResource::collection($this->archiveRepository->get()),
            'Archives retrieved successfully.'
        );
    }

    public function delete(Archive $archive): JsonResponse
    {
        return DB::transaction(function () use ($archive) {
            $payload = $archive->archivable instanceof Event
                ? ['status' => EventStatus::Completed->value]
                : ['status' => ReportStatus::Active->value];

            $archive->archivable()->update($payload);
            $this->archiveRepository->delete($archive);

            return Response::success(
                null,
                'Archive deleted successfully.'
            );
        });
    }
}
