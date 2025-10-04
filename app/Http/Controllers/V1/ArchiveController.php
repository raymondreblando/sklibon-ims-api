<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Services\V1\ArchiveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ArchiveController extends Controller
{
    public function __construct(
        private ArchiveService $archiveService
    ){}

    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Archive::class);

        return $this->archiveService->get();
    }

    public function destroy(Archive $archive): JsonResponse
    {
        Gate::authorize('delete', $archive);
        
        return $this->archiveService->delete($archive);
    }
}
