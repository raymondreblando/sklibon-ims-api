<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'status' => $this->resource->status,
            'profile' => $this->resource->profile,
            'info' => new UserInfoResource($this->whenLoaded('userInfo')),
            'role' => new RoleResource($this->whenLoaded('role')),
        ];
    }
}
