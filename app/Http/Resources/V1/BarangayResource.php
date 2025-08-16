<?php

namespace App\Http\Resources\V1;

use App\Traits\Resource\MapFields;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangayResource extends JsonResource
{
    use MapFields;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->mapFields($this->resource);
    }
}
