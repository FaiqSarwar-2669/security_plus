<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel-chat', function ($user) {
    return true;
});
