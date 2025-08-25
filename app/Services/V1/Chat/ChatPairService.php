<?php

namespace App\Services\V1\Chat;

use App\Models\Chat;
use App\Models\ChatPair;
use App\Repositories\ChatPairRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class ChatPairService
{
    use HasAuthUser;

    public function __construct(
        private ChatPairRepository $chatPairRepository
    ){}

    public function save(Chat $chat, array $data): ChatPair
    {
        return $this->chatPairRepository->create($chat, $data);
    }

    public function verifyPrivateChat(string $receiverId): ?ChatPair
    {
        return $this->chatPairRepository->findUserPair($this->getAuthUserId(), $receiverId);
    }
}
