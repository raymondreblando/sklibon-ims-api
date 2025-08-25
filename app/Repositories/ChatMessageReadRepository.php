<?php

namespace App\Repositories;

use App\Models\ChatMessage;
use App\Models\ChatMessageRead;

interface ChatMessageReadRepository
{
    public function create(ChatMessage $chatMessage, array $data): ChatMessageRead;
}
