<?php

namespace App\Services\V1;

use App\Http\Resources\V1\ArchiveResource;
use App\Repositories\ArchiveRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

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
}
