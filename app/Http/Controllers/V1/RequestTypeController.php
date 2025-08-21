<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RequestType\StoreRequestTypeRequest;
use App\Http\Requests\V1\RequestType\UpdateRequestTypeRequest;
use App\Models\RequestType;
use App\Services\V1\RequestTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RequestTypeController extends Controller
{
    public function __construct(
        private RequestTypeService $requestTypeService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', RequestType::class);

        return $this->requestTypeService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestTypeRequest $request): JsonResponse
    {
        Gate::authorize('create', RequestType::class);

        $data = $request->validated();
        return $this->requestTypeService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestType $requestType): JsonResponse
    {
        Gate::authorize('view', $requestType);

        return $this->requestTypeService->find($requestType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequestTypeRequest $request, RequestType $requestType)
    {
        Gate::authorize('update', $requestType);

        $data = $request->validated();
        return $this->requestTypeService->update($requestType, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestType $requestType)
    {
        //
    }
}
