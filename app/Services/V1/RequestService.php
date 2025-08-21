<?php

namespace App\Services\V1;

use App\Http\Resources\V1\RequestResource;
use App\Models\Request;
use App\Models\User;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereIn;
use App\Repositories\RequestRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class RequestService
{
    use HasAuthUser;

    protected array $receivableTypes = [
        'user' => 'App\Models\User',
        'barangay' => 'App\Models\Barangay',
    ];

    public function __construct(
        private RequestRepository $requestRepository
    ){}

    public function get(?string $action): JsonResponse
    {
        $criteria = [];

        if ($action === 'for-approval' && $this->user()) {
            $criteria[] = new WhereIn('receivable_id', [
                $this->getAuthUserId(),
                $this->getAuthUserBarangay()
            ]);
        } elseif (! $this->isAdmin() && $this->user()) {
            $criteria[] = new Where('user_id', $this->getAuthUserId());
        }

        $requests = $this->requestRepository->get($criteria);

        return Response::success(
            RequestResource::collection($requests),
            'Requests retrieved successfully.'
        );
    }

    public function save(User $user, array $data): JsonResponse
    {
        $data['receivable_type'] = $this->getReceivableType($data['receivable_type']);

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
        $data['receivable_type'] = $this->getReceivableType($data['receivable_type']);

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

    private function getReceivableType(?string $type): ?string
    {
        return $this->receivableTypes[$type] ?? null;
    }
}
