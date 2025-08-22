<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GalleryImage\StoreGalleryImageRequest;
use App\Models\GalleryImage;
use App\Services\V1\GalleryImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GalleryImageController extends Controller
{
    public function __construct(
        private GalleryImageService $galleryImageService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryImageRequest $request)
    {
        Gate::authorize('create', GalleryImage::class);

        $data = $request->validated();
        return $this->galleryImageService->save($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryImage $galleryImage): JsonResponse
    {
        Gate::authorize('delete', $galleryImage);

        return $this->galleryImageService->delete($galleryImage);
    }
}
