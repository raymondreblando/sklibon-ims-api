<?php

namespace App\Services\V1\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\ChatMessageRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class ChatMessageService
{
    public function __construct(
        private ChatMessageRepository $chatMessageRepository
    ){}

    public function saveMessageForNewRoom(Chat $chat, array $data): ChatMessage
    {
        return $this->chatMessageRepository->create($chat, $data);
    }
}
