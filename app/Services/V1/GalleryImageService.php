<?php

namespace App\Services\V1;

use App\Http\Resources\V1\GalleryImageResource;
use App\Models\Gallery;
use App\Models\GalleryImage;
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

    public function save(array $data): JsonResponse
    {
        $gallery = $this->galleryRepository->findById($data['gallery_id']);

        $galleryImage = $this->galleryImageRepository->create($gallery, ['image_url' => $data['image_url']]);

        return Response::success(
            new GalleryImageResource($galleryImage),
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
