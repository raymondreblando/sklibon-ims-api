<?php

namespace App\Services\V1\Chat;

use App\Events\PrivateChatCreated;
use App\Models\Chat;
use App\Repositories\ChatRepository;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WithRelations;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreatePrivateChatService
{
    use HasAuthUser;

    public function __construct(
        private ChatRepository $chatRepository,
        private ChatPairService $chatPairService,
        private ChatParticipantService $chatParticipantService,
        private ChatMessageService $chatMessageService,
        private ChatMessageReadService $chatMessageReadService,
    ){}

    public function create(array $data): JsonResponse
    {
        $chatPair = $this->chatPairService->verifyPrivateChat($data['receiver_id']);

        if ($chatPair) {
            return Response::success(['chatId' => $chatPair->chat_id]);
        }

        return DB::transaction(function () use ($data) {
            $user = $this->user();

            $chat = $this->chatRepository->create($user, [
                'type' => 'private',
                'last_message' => $data['message'],
                'last_message_at' => now()
            ]);

            $this->setupNewPrivateChat($chat, $data);

            $criteria = [
                new Where('id', $chat->id),
                new WithRelations([
                    'chatPair.sender:id,profile',
                    'chatPair.sender.userInfo:id,user_id,firstname,lastname',
                    'chatPair.receiver:id,profile',
                    'chatPair.receiver.userInfo:id,user_id,firstname,lastname',
                ])
            ];

            $chatWithRelations = $this->chatRepository->find($criteria);

            PrivateChatCreated::dispatch($chatWithRelations);
            return Response::success(['chatId' => $chat->id]);
        });
    }

    private function setupNewPrivateChat(Chat $chat, array $data): void
    {
       $senderId = $this->getAuthUserId();
       $receiverId = $data['receiver_id'];
       unset($data['receiver_id']);

       $this->chatPairService->save($chat, [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId
       ]);

       $this->chatParticipantService->saveMultiple($chat, [
            ['user_id' => $senderId],
            ['user_id' => $receiverId]
       ]);

       $messagePayload = array_merge($data, ['user_id' => $senderId]);
       $chatMessage = $this->chatMessageService->saveMessageForNewRoom($chat, $messagePayload);

       $this->chatMessageReadService->save($chatMessage, ['user_id' => $receiverId]);
    }
}
