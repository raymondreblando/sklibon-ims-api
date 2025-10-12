<?php

namespace App\Services\V1\Chat;

use App\Events\MessageSent;
use App\Http\Resources\V1\ChatMessageResource;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\ChatMessageRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ChatMessageService
{
    public function __construct(
        private ChatMessageRepository $chatMessageRepository,
        private ChatMessageReadService $chatMessageReadService,
    ){}

    public function save(Chat $chat, array $data): JsonResponse
    {
        return DB::transaction(function () use ($chat, $data) {
            $message = $this->chatMessageRepository->create($chat, [
                'user_id' => $data['user_id'],
                'message' => $data['message']
            ]);

            if ($chat->type === 'private') {
                $this->chatMessageReadService->save($message, ['user_id' => $data['receiver_id']]);
            }

            MessageSent::dispatch($message);

            return Response::success(
                new ChatMessageResource($message),
                'Message sent successfully.'
            );
        });
    }

    public function saveMessageForNewRoom(Chat $chat, array $data): ChatMessage
    {
        return $this->chatMessageRepository->create($chat, $data);
    }
}
