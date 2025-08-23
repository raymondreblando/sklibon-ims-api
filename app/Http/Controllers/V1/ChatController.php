<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Chat\StoreGroupChatRequest;
use App\Http\Requests\V1\Chat\StorePrivateChatRequest;
use App\Services\V1\Chat\CreateGroupChatService;
use App\Services\V1\Chat\CreatePrivateChatService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
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
}
