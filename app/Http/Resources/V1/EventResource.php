<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'eventDate' => $this->resource->event_date,
            'imageUrl' => $this->resource->image_url,
            'status' => $this->resource->status,
            'latitude' => $this->resource->latitude,
            'longitude' => $this->resource->longitude,
            'barangay' => new BarangayResource($this->whenLoaded('barangay')),
            'creator' => new MinifyUserResource($this->whenLoaded('user')),
            'attendances' => AttendanceResource::collection($this->whenLoaded('attendances'))
        ];
    }
}
