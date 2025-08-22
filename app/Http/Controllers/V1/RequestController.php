<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Request\StoreRequestRequest;
use App\Http\Requests\V1\Request\UpdateRequestRequest;
use App\Models\Request;
use App\Services\V1\RequestService;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RequestController extends Controller
{
    public function __construct(
        private RequestService $requestService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(HttpRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', Request::class);

        $action = $request->query('action');
        return $this->requestService->get($action);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request): JsonResponse
    {
        Gate::authorize('create', Request::class);

        $data = $request->validated();
        return $this->requestService->save(Auth::user(), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        Gate::authorize('view', $request);

        return $this->requestService->find($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequestRequest $httpRequest, Request $request)
    {
        Gate::authorize('update', $request);

        $data = $httpRequest->validated();
        return $this->requestService->update($request, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Gate::authorize('delete', $request);

        return $this->requestService->delete($request);
    }
}
