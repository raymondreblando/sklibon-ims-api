<?php

namespace App\Repositories;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface GalleryRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(User $user,  array $data): Gallery;
    public function find(Gallery $gallery, array $relations = []): Gallery;
    public function findById(string $id): ?Gallery;
    public function update(Gallery $gallery, array $data): Gallery;
    public function delete(Gallery $gallery): bool;
}
