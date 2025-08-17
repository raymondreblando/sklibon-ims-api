<?php

namespace App\Services\V1;

use App\Http\Resources\V1\HotlineResource;
use App\Repositories\HotlineRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class HotlineService
{
    public function __construct(
        private HotlineRepository $hotlineRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            HotlineResource::collection($this->hotlineRepository->get()),
            'Hotlines retrieved successfully.'
        );
    }
}
