<?php

namespace App\Services\V1\Chat;

use App\Http\Resources\V1\ChatResource;
use App\Models\Chat;
use App\Repositories\ChatRepository;
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
        $criteria = [
            new WithRelations([
                'chatParticipants' => function (Builder $query) {
                    $query->whereNot('user_id', $this->getAuthUserId())
                        ->limit(1)
                        ->with([
                            'user:id,profile',
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
}
