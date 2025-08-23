<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\ChatMessageRepository;

class EloquentChatMessageRepository implements ChatMessageRepository
{
    public function create(Chat $chat, array $data): ChatMessage
    {
        return $chat->chatMessages()->create($data);
    }
}
