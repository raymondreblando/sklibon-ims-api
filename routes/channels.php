<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.user.{id}', function (User $user, string $receiverId) {
    return $user->id === $receiverId;
});

Broadcast::channel('notification.barangay.{id}', function (User $user, string $receiverId) {
    return $user->userInfo->barangay_id === $receiverId;
});

Broadcast::channel('notification.announcements', function () {
    return true;
});

Broadcast::channel('chat.list.{id}', function (User $user, string $id) {
    return $user->id === $id;
});

Broadcast::channel('chat.room.{id}', function (User $user, string $id) {
    return $user->chats()->where('chat_id', $id)->exists();
});
