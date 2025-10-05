<?php

namespace App\Services\V1;

use App\Http\Resources\V1\GalleryImageResource;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Repositories\Criteria\Limit;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\GalleryImageRepository;
use App\Repositories\GalleryRepository;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class GalleryImageService
{
    public function __construct(
        private GalleryImageRepository $galleryImageRepository,
        private GalleryRepository $galleryRepository
    ){}

    public function get(): JsonResponse
    {
        $criteria = [
            new OrderBy('id', 'desc'),
            new Limit(7)
        ];

        return Response::success(
            GalleryImageResource::collection($this->galleryImageRepository->get($criteria)),
            "Gallery images retrieved successfully."
        );
    }

    public function save(array $data): JsonResponse
    {
        $gallery = $this->galleryRepository->findById($data['gallery_id']);

        $this->galleryImageRepository->createMany($gallery, $data['images']);

        return Response::success(
            null,
            'Gallery image created successfully.'
        );
    }

    public function saveMany(Gallery $gallery, array $images): Collection
    {
        return $this->galleryImageRepository->createMany($gallery, $images);
    }

    public function delete(GalleryImage $galleryImage): JsonResponse
    {
        $this->galleryImageRepository->delete($galleryImage);

        return Response::success(null, 'Gallery image deleted successfully.');
    }
}
