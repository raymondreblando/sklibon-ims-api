<?php

namespace App\Repositories;

use App\Models\RequestType;
use Illuminate\Database\Eloquent\Collection;

interface RequestTypeRepository
{
    public function get(): Collection;
    public function create(array $data): RequestType;
    public function find(RequestType $requestType): RequestType;
    public function update(RequestType $requestType, array $data): RequestType;
    public function delete(RequestType $requestType): bool;
}
