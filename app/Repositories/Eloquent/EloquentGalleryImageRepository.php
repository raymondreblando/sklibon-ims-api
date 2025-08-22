<?php

namespace App\Repositories\Eloquent;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Repositories\GalleryImageRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentGalleryImageRepository implements GalleryImageRepository
{
    public function create(Gallery $gallery, array $data): GalleryImage
    {
        return $gallery->images()->create($data);
    }

    public function createMany(Gallery $gallery, array $data): Collection
    {
        return $gallery->images()->createMany($data);
    }

    public function delete(GalleryImage $galleryImage): bool
    {
        return $galleryImage->delete();
    }
}
