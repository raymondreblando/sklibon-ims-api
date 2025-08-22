<?php

namespace App\Services\V1;

use App\Http\Resources\V1\GalleryResource;
use App\Models\Gallery;
use App\Repositories\GalleryRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GalleryService
{
    use HasAuthUser;

    public function __construct(
        private GalleryRepository $galleryRepository,
        private GalleryImageService $galleryImageService
    ){}

    public function get(): JsonResponse
    {
        return Response::success(
            GalleryResource::collection($this->galleryRepository->get()),
            'Galleries retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $galleryPayload = Arr::except($data, ['images']);

            $gallery = $this->galleryRepository->create($this->user(), $galleryPayload);

            $this->galleryImageService->saveMany($gallery, $data['images']);

            return Response::success(
                new GalleryResource($gallery->load('images')),
                'Gallery created successfully.'
            );
        });
    }

    public function find(Gallery $gallery): JsonResponse
    {
        $gallery = $this->galleryRepository->find($gallery);

        return Response::success(
            new GalleryResource($gallery),
            'Gallery retrieved successfully.'
        );
    }

    public function update(Gallery $gallery, array $data): JsonResponse
    {
        $gallery = $this->galleryRepository->update($gallery, $data);

        return Response::success(
            new GalleryResource($gallery),
            'Gallery updated successfully.'
        );
    }
}
