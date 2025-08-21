<?php

namespace App\Repositories\Eloquent;

use App\Models\RequestType;
use App\Repositories\RequestTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentRequestTypeRepository implements RequestTypeRepository
{
    public function get(): Collection
    {
        return RequestType::orderBy('id', 'desc')->get();
    }

    public function create(array $data): RequestType
    {
        return RequestType::create($data);
    }

    public function find(RequestType $requestType): RequestType
    {
        return $requestType;
    }

    public function update(RequestType $requestType, array $data): RequestType
    {
        $requestType->update($data);
        return $requestType;
    }

    public function delete(RequestType $requestType): bool
    {
        return $requestType->delete();
    }
}
