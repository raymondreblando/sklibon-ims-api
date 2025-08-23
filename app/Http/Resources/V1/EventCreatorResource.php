<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventCreatorResource extends JsonResource
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
            'firstname' => $this->resource->userInfo->firstname,
            'lastname' => $this->resource->userInfo->lastname
        ];
    }
}
