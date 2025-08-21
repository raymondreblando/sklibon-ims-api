<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface RequestRepository
{
    public function get(array $relations = []): Collection;
    public function create(User $user, array $data): Request;
    public function find(Request $request, array $relations = []): Request;
    public function update(Request $request, array $data): Request;
    public function delete(Request $request): bool;
}
