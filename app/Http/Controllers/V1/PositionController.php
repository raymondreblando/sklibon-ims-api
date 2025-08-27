<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Position\StorePositionRequest;
use App\Http\Requests\V1\Position\UpdatePositionRequest;
use App\Models\Position;
use App\Services\V1\PositionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class PositionController extends Controller
{
    public function __construct(
        private PositionService $positionService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->positionService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request): JsonResponse
    {
        Gate::authorize('create', Position::class);

        $data = $request->validated();
        return $this->positionService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position): JsonResponse
    {
        Gate::authorize('view', $position);

        return $this->positionService->find($position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position): JsonResponse
    {
        Gate::authorize('update', $position);

        $data = $request->validated();
        return $this->positionService->update($position, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position): JsonResponse
    {
        Gate::authorize('delete', $position);
        return $this->positionService->delete($position);
    }
}
