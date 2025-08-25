<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'type' => $this->resource->type,
            'lastMessage' => $this->resource->last_message,
            'lastMessageAt' => $this->resource->last_message_at,
            'participants' => ChatParticipantResource::collection($this->whenLoaded('chatParticipants'))
        ];
    }
}
