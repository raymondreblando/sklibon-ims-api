<?php

namespace App\Services\V1;

use App\Http\Resources\V1\RequestResource;
use App\Repositories\RequestRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class RequestService
{
    public function __construct(
        private RequestRepository $requestRepository
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            RequestResource::collection($this->requestRepository->get()),
            'Requests retrieved successfully.'
        );
    }
}
