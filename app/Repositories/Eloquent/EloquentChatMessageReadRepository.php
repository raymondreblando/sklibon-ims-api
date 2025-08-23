<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatMessageRead;
use App\Repositories\ChatMessageReadRepository;

class EloquentChatMessageReadRepository implements ChatMessageReadRepository
{
    public function create(ChatMessage $chatMessage, array $data): ChatMessageRead
    {
        return $chatMessage->chatMessageRead()->create($data);
    }
}
