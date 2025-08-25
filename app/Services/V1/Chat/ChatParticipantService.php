<?php

namespace App\Services\V1\Chat;

use App\Events\ParticipantAdded;
use App\Http\Resources\V1\ChatParticipantResource;
use App\Models\Chat;
use App\Repositories\ChatParticipantRepository;
use App\Repositories\Criteria\Where;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ChatParticipantService
{
    use HasAuthUser;

    public function __construct(
        private ChatParticipantRepository $chatParticipantRepository,
        private ChatService $chatService
    ){}

    public function get(array $queryParams): JsonResponse
    {
        $chatId = $queryParams['chat-id'] ?? '';

        $result = $this->chatService->verifyChatRoom($chatId);

        if (is_string($result)) {
            return Response::error($result);
        }

        if ($result instanceof Chat && ! $result->isParticipant($this->user())) {
            return Response::error('Unauthorized participant.', 403);
        }

        $criteria =  [new Where('chat_id', $chatId)];
        $chatParticipants = $this->chatParticipantRepository->get($criteria);

        return Response::success(
            ChatParticipantResource::collection($chatParticipants),
            'Participants retrieved successfully.'
        );
    }

    public function save(array $data): JsonResponse
    {
        $chatId = $data['chat_id'];
        unset($data['chat_id']);

        $result = $this->chatService->verifyChatRoom($chatId);

        if (is_string($result)) {
            return Response::error($result);
        }

        if ($result instanceof Chat && ! $result->isChatCreator($this->user())) {
            return Response::error('Unauthorized.', 403);
        }

        $participants = $this->chatParticipantRepository->create($result, $data['participants']);
        ParticipantAdded::dispatch($participants);

        return Response::success(
            ChatParticipantResource::collection($participants->load('user')),
            'Participants added successfully'
        );
    }

    public function saveMultiple(Chat $chat, array $data): Collection
    {
        return $this->chatParticipantRepository->create($chat, $data);
    }

    public function delete(string $id): JsonResponse
    {
        $chatParticipant = $this->chatParticipantRepository->findById($id);
        $chat = $this->chatService->find($chatParticipant->chat_id);

        if (! $chat->isChatCreator($this->user())) {
            return Response::error('Unauthorized.', 403);
        }

        $this->chatParticipantRepository->delete($chatParticipant);

        return Response::success(null, 'Chat participant removed successfully.');
    }
}
