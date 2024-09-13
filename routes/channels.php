<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('channel-chat', function ($user) {
//     return true;
// });
Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId;
});
