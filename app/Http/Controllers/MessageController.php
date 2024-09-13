<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Messagemodel;
use App\Models\chatUsers;
use App\Models\registeration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $record = [];
        $user = Auth::user();
        if ($user->bussiness_type == 'Provider') {
            $chatUser = chatUsers::where('members', $user->id)->get();
            foreach ($chatUser as $chatUsers) {
                $specificUser = registeration::where('id', $chatUsers->current)->first();
                if ($specificUser) {
                    $record[] = [
                        'id' => $specificUser->id,
                        'name' => $specificUser->bussiness_owner,
                        'profile' => $specificUser->profile,
                    ];
                }
            }
        } else if ($user->bussiness_type == 'Taker') {
            $chatUser = chatUsers::where('current', $user->id)->get();
            foreach ($chatUser as $chatUsers) {
                $specificUser = registeration::where('id', $chatUsers->members)->first();
                if ($specificUser) {
                    $record[] = [
                        'id' => $specificUser->id,
                        'name' => $specificUser->bussiness_owner,
                        'profile' => $specificUser->profile,
                    ];
                }
            }
        }

        return response()->json([
            'data' => $record
        ]);
    }


    public function create(Request $request)
    {
        $authUser = Auth::user();

        $user = chatUsers::where('members', $request->input('member'))
            ->where('current', $authUser->id)->first();
        if ($user) {
            return response()->json([
                'message' => 'Already Found'
            ]);
        } else {
            $data = new chatUsers();
            $data->current = $authUser->id;
            $data->members = $request->input('member');
            $data->save();
            return response()->json([
                'message' => 'Added caht member'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $message = Messagemodel::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        event(new MessageEvent($message));
        return response()->json([
            'data' => $message
        ]);
    }


    public function getMessage(string $id)
    {
        $user = Auth::user();
        $messages = Messagemodel::where(function($query) use ($user, $id) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $id);
        })->orWhere(function($query) use ($user, $id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', $user->id);
        })->get();
        return response()->json([
            'data' => $messages
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
