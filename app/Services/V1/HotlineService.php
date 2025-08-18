<?php

namespace App\Services\V1;

use App\Http\Resources\V1\HotlineResource;
use App\Models\Hotline;
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

    public function save(array $data): JsonResponse
    {
        $hotline = $this->hotlineRepository->create($data);

        return Response::success(
            new HotlineResource($hotline),
            'Hotline created successfully.'
        );
    }

    public function find(Hotline $hotline): JsonResponse
    {
        return Response::success(
            new HotlineResource($hotline),
            'Hotline retrieved successfully.'
        );
    }

    public function update(Hotline $hotline, array $data): JsonResponse
    {
        $hotline = $this->hotlineRepository->update($hotline, $data);

        return Response::success(
            new HotlineResource($hotline),
            'Hotline updated successfully.'
        );
    }
}
