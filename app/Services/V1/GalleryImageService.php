<?php

namespace App\Services\V1;

use App\Models\Gallery;
use App\Repositories\GalleryImageRepository;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class GalleryImageService
{
    public function __construct(
        private GalleryImageRepository $galleryImageRepository
    ){}

    public function saveMany(Gallery $gallery, array $images): Collection
    {
        return $this->galleryImageRepository->createMany($gallery, $images);
    }
}
