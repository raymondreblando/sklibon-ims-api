<?php

namespace App\Services\V1;

use App\Http\Resources\V1\RequestTypeResource;
use App\Repositories\RequestTypeRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class RequestTypeService
{
    public function __construct(
        private RequestTypeRepository $requestTypeRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            RequestTypeResource::collection($this->requestTypeRepository->get()),
            'Request types retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        $requestType = $this->requestTypeRepository->create($data);

        return Response::success(
            new RequestTypeResource($requestType),
            'Request type created successfully.'
        );
    }
}
