<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MinifyUserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstname' => $this->resource->firstname,
            'lastname' => $this->resource->lastname,
            'position' => new MinifyPositionResource($this->whenLoaded('position')),
            'barangay' => new BarangayResource($this->whenLoaded('barangay')),
        ];
    }
}
