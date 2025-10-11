<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MinifyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'profile' => $this->resource->profile,
            'isOnline' => $this->resource->is_online,
            'info' => new MinifyUserInfoResource($this->whenLoaded('userInfo')),
        ];
    }
}
