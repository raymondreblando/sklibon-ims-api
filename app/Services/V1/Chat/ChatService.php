<?php

namespace App\Services\V1\Chat;

use App\Http\Resources\V1\ChatResource;
use App\Http\Resources\V1\MessageResource;
use App\Models\Chat;
use App\Repositories\ChatRepository;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereHas;
use App\Repositories\Criteria\WithRelations;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ChatService
{
    use HasAuthUser;

    public function __construct(
        private ChatRepository $chatRepository,
        private ChatMessageService $chatMessageService
    ){}

    public function get(): JsonResponse
    {
        $userId = $this->getAuthUserId();

        $criteria = [
            new WhereHas('chatParticipants', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            }),
            new WithRelations([
                'chatParticipants' => function (Builder $query) use ($userId) {
                    $query->whereNot('user_id', $userId)
                        ->limit(1)
                        ->with([
                            'user:id,profile,is_online',
                            'user.userInfo:id,user_id,firstname,lastname'
                        ]);
                },
            ])
        ];

        return Response::success(
            ChatResource::collection($this->chatRepository->get($criteria)),
            'Chats retrieved successfully.'
        );
    }

    public function getMessages(Chat $chat): JsonResponse
    {
        $criteria = [
            new Where('id', $chat->id),
            new WithRelations([
                'chatMessages',
                'chatMessages.user:id,profile,is_online',
                'chatMessages.user.userInfo:id,user_id,firstname,lastname',
                'chatParticipants' => function (Builder $query) {
                    $query->whereNot('user_id', $this->getAuthUserId())
                        ->with([
                            'user:id,profile,is_online',
                            'user.userInfo:id,user_id,firstname,lastname'
                        ]);
                }
            ])
        ];

        return Response::success(
            new MessageResource($this->chatRepository->find($criteria)),
            'Chat messages retrieved successfully.'
        );
    }

    public function find(string $id): ?Chat
    {
        return $this->chatRepository->findById($id);
    }

    public function update(Chat $chat, array $data): JsonResponse
    {
        return DB::transaction(function () use ($chat, $data) {
            $this->chatRepository->update($chat, [
                'last_message' => $data['message'],
                'last_message_at' => now()
            ]);

            $data['user_id'] = $this->getAuthUserId();
            return $this->chatMessageService->save($chat, $data);
        });
    }

    public function verifyChatRoom(string $chatId): string|Chat
    {
        if (empty($chatId))
            return 'No chat room was specified.';

        $chat = $this->find($chatId);

        if (empty($chat))
            return 'Chat room does not exists.';

        if ($chat->type !== 'group')
            return 'Chat room does not support participants';

        if (! $chat->isParticipant($this->user()))
            return 'Unauthorized.';

        return $chat;
    }
}
