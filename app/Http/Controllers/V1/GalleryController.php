<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Gallery\StoreGalleryRequest;
use App\Http\Requests\V1\Gallery\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Services\V1\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $galleryService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Gallery::class);

        return $this->galleryService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        Gate::authorize('create', Gallery::class);

        $data = $request->validated();
        return $this->galleryService->save($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery): JsonResponse
    {
        Gate::authorize('view', $gallery);

        return $this->galleryService->find($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery): JsonResponse
    {
        Gate::authorize('update', $gallery);

        $data = $request->validated();
        return $this->galleryService->update($gallery, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        Gate::authorize('delete', $gallery);

        return $this->galleryService->delete($gallery);
    }
}
