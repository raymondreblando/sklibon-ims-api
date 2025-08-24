<?php

namespace App\Services\V1\Chat;

use App\Http\Resources\V1\ChatParticipantResource;
use App\Models\Chat;
use App\Repositories\ChatParticipantRepository;
use App\Repositories\Criteria\Where;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ChatParticipantService
{
    public function __construct(
        private ChatParticipantRepository $chatParticipantRepository,
        private ChatService $chatService
    ){}

    public function get(array $queryParams): JsonResponse
    {
        $chatId = $queryParams['chat-id'] ?? '';

        $validation = $this->verifyChatRoom($chatId);

        if (! empty($validation)) {
            return Response::error($validation);
        }

        $criteria =  [new Where('chat_id', $chatId)];
        $chatParticipants = $this->chatParticipantRepository->get($criteria);

        return Response::success(
            ChatParticipantResource::collection($chatParticipants),
            'Participants retrieved successfully.'
        );
    }

    public function saveMultiple(Chat $chat, array $data): Collection
    {
        return $this->chatParticipantRepository->create($chat, $data);
    }

    private function verifyChatRoom(string $chatId): string|null
    {
        if (empty($chatId))
            return 'No chat room was specified.';

        $chat = $this->chatService->find($chatId);

        if (empty($chat))
            return 'Chat room does not exists.';

        if ($chat->type !== 'group')
            return 'Chat room does not support participants';

        return null;
    }
}
