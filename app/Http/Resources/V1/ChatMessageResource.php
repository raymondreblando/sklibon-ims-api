<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
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
            'chatId' => $this->resource->chat_id,
            'userId' => $this->resource->user_id,
            'message' => $this->resource->message,
            'attachment' => $this->resource->attachment,
            'user' => new MinifyUserResource($this->whenLoaded('user')),
        ];
    }
}
