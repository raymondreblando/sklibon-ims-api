<?php

namespace App\Http\Resources\V1;

use App\Traits\Resource\MapFields;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{
    use MapFields;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'status' => $this->resource->status,
            'createdAt' => $this->resource->created_at,
            'users' => PositionUserInfoResource::collection($this->whenLoaded('userInfos'))
        ];
    }
}
