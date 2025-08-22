<?php

namespace App\Repositories\Eloquent;

use App\Models\Gallery;
use App\Models\User;
use App\Repositories\GalleryRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentGalleryRepository implements GalleryRepository
{
    protected array $relations = [];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        return Gallery::all()->sortByDesc("primary");
    }

    public function create(User $user, array $data): Gallery
    {
        return $user->galleries()->create($data);
    }

    public function find(Gallery $gallery, array $relations = []): Gallery
    {
        return $gallery;
    }

    public function update(Gallery $gallery, array $data): Gallery
    {
        $gallery->update($data);
        return $gallery;
    }

    public function delete(Gallery $gallery): bool
    {
        return $gallery->delete();
    }
}
