<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'timeIn' => $this->resource->time_in,
            'timeOut' => $this->resource->time_out,
            'user' => new MinifyUserResource($this->whenLoaded('user')),
            'event' => new EventResource($this->whenLoaded('event'))
        ];
    }
}
