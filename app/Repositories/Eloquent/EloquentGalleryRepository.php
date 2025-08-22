<?php

namespace App\Repositories\Eloquent;

use App\Models\Gallery;
use App\Models\User;
use App\Repositories\GalleryRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentGalleryRepository implements GalleryRepository
{
    protected array $relations = [
        'user.userInfo:id,user_id,firstname,lastname',
        'images:id,gallery_id,image_url'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        return Gallery::with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
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
