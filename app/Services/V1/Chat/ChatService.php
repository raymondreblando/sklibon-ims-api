<?php

namespace App\Services\V1\Chat;

use App\Models\Chat;
use App\Repositories\ChatRepository;
use App\Traits\Auth\HasAuthUser;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ChatService
{
    use HasAuthUser;

    public function __construct(
        private ChatRepository $chatRepository,
        private ChatPairService $chatPairService,
        private ChatMessageService $chatMessageService,
        private ChatMessageReadService $chatMessageReadService,
        private ChatParticipantService $chatParticipantService,
    ){}

}
