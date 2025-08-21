<?php

namespace App\Services\V1;

use App\Http\Resources\V1\RequestResource;
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
        private RequestRepository $requestRepository,
        private UploadService $uploadService
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            RequestResource::collection($this->requestRepository->get()),
            'Requests retrieved successfully.'
        );
    }

    public function save(User $user, array $data, UploadedFile $attachment): JsonResponse
    {
        if (! $attachment)
            return Response::error('Attachment is required.', 422);

        return DB::transaction(function () use ($data, $attachment, $user) {
            $data['receivable_type'] = $this->receivableTypes[$data['receivable_type']] ?? null;

            $request = $this->requestRepository->create($user, $data);

            $attachmentPath = $this->uploadService->upload($attachment, $request->id, 'attachments');
            $this->requestRepository->update($request, ['attachment' => $attachmentPath]);

            return Response::success(
                new RequestResource($request),
                'Request created successfully.'
            );
        });
    }
}
