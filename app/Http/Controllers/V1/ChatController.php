<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Chat\StoreGroupChatRequest;
use App\Http\Requests\V1\Chat\StoreMessageRequest;
use App\Http\Requests\V1\Chat\StorePrivateChatRequest;
use App\Models\Chat;
use App\Services\V1\Chat\ChatService;
use App\Services\V1\Chat\CreateGroupChatService;
use App\Services\V1\Chat\CreatePrivateChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ChatController extends Controller
{
    public function index(ChatService $chatService): JsonResponse
    {
        return $chatService->get();
    }

    public function storePrivateChat(
        StorePrivateChatRequest $request,
        CreatePrivateChatService $createPrivateChatService
    ): JsonResponse {
        $data = $request->validated();
        return $createPrivateChatService->create($data);
    }

    public function storeGroupChat(
        StoreGroupChatRequest $request,
        CreateGroupChatService $createPrivateChatService
    ): JsonResponse {
        $data = $request->validated();
        return $createPrivateChatService->create($data);
    }

    public function send(
        StoreMessageRequest $request,
        ChatService $chatService,
        Chat $chat
    ): JsonResponse {
        Gate::authorize('update', $chat);

        $data = $request->validated();
        return $chatService->update($chat, $data);
    }

    public function messages(Chat $chat, ChatService $chatService) : JsonResponse
    {
        return $chatService->getMessages($chat);
    }
}
