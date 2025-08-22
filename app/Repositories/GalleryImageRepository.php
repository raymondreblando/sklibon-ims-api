<?php

namespace App\Repositories;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Collection;

interface GalleryImageRepository
{
    public function create(Gallery $gallery, array $data): GalleryImage;
    public function createMany(Gallery $gallery, array $data): Collection;
    public function delete(GalleryImage $galleryImage): bool;
}
