<?php

namespace App\Services\V1\Chat;

use App\Models\Chat;
use App\Repositories\ChatParticipantRepository;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ChatParticipantService
{
    public function __construct(
        private ChatParticipantRepository $chatParticipantRepository
    ){}

    public function saveMultiple(Chat $chat, array $data): Collection
    {
        return $this->chatParticipantRepository->create($chat, $data);
    }
}
