<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $message = $request->message;
        $user = auth()->user(); // Replace with appropriate authentication logic

        // Store message in database (if applicable)
        // ...

        broadcast(new NewChatMessage($message, $user))->toOthers();

        return response()->json(['success' => true]);
    }

}
