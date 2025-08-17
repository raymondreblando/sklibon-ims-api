<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreHotlineRequest;
use App\Models\Hotline;
use App\Services\V1\HotlineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HotlineController extends Controller
{
    public function __construct(
        private HotlineService $hotlineService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Hotline::class);

        return $this->hotlineService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotlineRequest $request): JsonResponse
    {
        Gate::authorize('create', Hotline::class);

        $data = $request->validated();
        return $this->hotlineService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotline $hotline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotline $hotline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotline $hotline)
    {
        //
    }
}
