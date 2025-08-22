<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.user.{id}', function (User $user, string $receiverId) {
    return $user->id === $receiverId;
});

Broadcast::channel('notification.barangay.{id}', function (User $user, string $receiverId) {
    return $user->userInfo->barangay_id === $receiverId;
});
