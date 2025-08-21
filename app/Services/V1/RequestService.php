<?php

namespace App\Services\V1;

use App\Http\Resources\V1\RequestResource;
use App\Models\Request;
use App\Models\User;
use App\Repositories\RequestRepository;
use App\Services\UploadService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class RequestService
{
    protected array $receivableTypes = [
        'user' => 'App\Models\User',
        'barangay' => 'App\Models\Barangay',
    ];

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

    public function save(User $user, array $data): JsonResponse
    {
        $data['receivable_type'] = $this->receivableTypes[$data['receivable_type']] ?? null;

        $request = $this->requestRepository->create($user, $data);

        return Response::success(
            new RequestResource($request),
            'Request created successfully.'
        );
    }

    public function find(Request $request): JsonResponse
    {
        $request = $this->requestRepository->find($request);

        return Response::success(
            new RequestResource($request),
            'Request retrieved successfully.'
        );
    }

    public function update(Request $request, array $data): JsonResponse
    {
        $data['receivable_type'] = $this->receivableTypes[$data['receivable_type']] ?? null;

        $this->requestRepository->update($request, $data);

        return Response::success(
            new RequestResource($request),
            'Request updated successfully.'
        );
    }

    public function delete(Request $request): JsonResponse
    {
        $this->requestRepository->delete($request);

        return Response::success(null, 'Request deleted successfully.');
    }
}
