<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'createdAt' => $this->resource->created_at,
            'uploader' => new MinifyUserResource($this->whenLoaded('user')),
            'images' => GalleryImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
