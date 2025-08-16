<?php

namespace App\Services\V1;

use App\Http\Resources\V1\PositionResource;
use App\Models\Position;
use App\Repositories\PositionRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class PositionService
{
    public function __construct(
        private PositionRepository $positionRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            PositionResource::collection($this->positionRepository->get()),
            'Positions retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        $position = $this->positionRepository->create($data);

        return Response::success(
            new PositionResource($position),
            'Position created successfully.'
        );
    }

    public function find(Position $position): JsonResponse
    {
        $position = $this->positionRepository->findById($position);

        return Response::success(
            new PositionResource($position),
            'Position retrieved successfully.'
        );
    }

    public function update(Position $position, array $data): JsonResponse
    {
        $position = $this->positionRepository->update($position, $data);

        return Response::success(
            new PositionResource($position),
            'Position updated successfully.'
        );
    }

    public function delete(Position $position): JsonResponse
    {
        $this->positionRepository->delete($position);

        return Response::success(null, 'Position deleted successfully.');
    }
}
