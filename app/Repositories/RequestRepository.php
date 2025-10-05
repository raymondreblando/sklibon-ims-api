<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;

interface RequestRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function getSummary(string $key, string $value, array $criteria = []): CollectionSupport;
    public function create(User $user, array $data): Request;
    public function find(Request $request, array $relations = []): Request;
    public function update(Request $request, array $data): Request;
    public function delete(Request $request): bool;
}
