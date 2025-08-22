<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Attachment\StoreAttachmentRequest;
use App\Models\Attachment;
use App\Services\V1\AttachmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class AttachmentController extends Controller
{
    public function __construct(
        private AttachmentService $attachmentService
    ){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttachmentRequest $request): JsonResponse
    {
        Gate::authorize('create', Attachment::class);

        $data = $request->validated();
        return $this->attachmentService->save($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment): JsonResponse
    {
        Gate::authorize('delete', $attachment);

        return $this->attachmentService->delete($attachment);
    }
}
