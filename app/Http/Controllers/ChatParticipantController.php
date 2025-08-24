<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\Chat\StoreParticipantRequest;
use App\Services\V1\Chat\ChatParticipantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatParticipantController extends Controller
{
    public function __construct(
        private ChatParticipantService $chatParticipantService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $queries = $request->query();
        return $this->chatParticipantService->get($queries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParticipantRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->chatParticipantService->save($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->chatParticipantService->delete($id);
    }
}
