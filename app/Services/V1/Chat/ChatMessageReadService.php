<?php

namespace App\Services\V1\Chat;

use App\Models\ChatMessage;
use App\Models\ChatMessageRead;
use App\Repositories\ChatMessageReadRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class ChatMessageReadService
{
    public function __construct(
        private ChatMessageReadRepository $chatMessageReadRepository
    ){}

    public function save(ChatMessage $chatMessage, array $data): ChatMessageRead
    {
        return $this->chatMessageReadRepository->create($chatMessage, $data);
    }
}
