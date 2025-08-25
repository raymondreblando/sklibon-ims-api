<?php

namespace App\Services\V1\Chat;

use App\Events\GroupChatCreated;
use App\Models\Chat;
use App\Repositories\ChatRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateGroupChatService
{
    use HasAuthUser;

    public function __construct(
        private ChatRepository $chatRepository,
        private ChatParticipantService $chatParticipantService,
        private ChatMessageService $chatMessageService,
    ){}

    public function create(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            $user = $this->user();

            $chat = $this->chatRepository->create($user, [
                'name' => $data['name'],
                'type' => 'group',
                'last_message' => $data['message'],
                'last_message_at' => now()
            ]);

            $this->setupNewGroupChat($chat, $data);

            GroupChatCreated::dispatch($chat);
            return Response::success(['chatId' => $chat->id]);
        });
    }

    private function setupNewGroupChat(Chat $chat, array $data)
    {
        $creatorId = $this->getAuthUserId();
        $participants = [['user_id' => $creatorId]];

        if (! empty($data['participants'])) {
            $participants = $data['participants'];
            unset($data['participants']);
        }

        $this->chatParticipantService->saveMultiple($chat, $participants);

        $messagePayload = array_merge($data, ['user_id' => $creatorId]);
        $this->chatMessageService->saveMessageForNewRoom($chat, $messagePayload);
    }
}
