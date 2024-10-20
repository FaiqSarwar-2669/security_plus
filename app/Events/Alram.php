<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Alram implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $data;
    public $id;
    public function __construct($message, $id)
    {
        $this->data = $message;
        $this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('alram');
    }
    public function broadcastAs()
    {
        return 'alert-alram';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->getdata(),
        ];
    }

    public function getdata()
    {
        $datareturn = [
            'message' => $this->data,
            'target' => $this->id
        ];
        return  $datareturn;
    }
}
