<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\ArchiveService;
use Illuminate\Http\JsonResponse;

class ArchiveController extends Controller
{
    public function __construct(
        private ArchiveService $archiveService
    ){}

    public function index(): JsonResponse
    {
        return $this->archiveService->get();
    }

    public function destroy(string $id)
    {
        //
    }
}
