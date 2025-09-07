<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat_id;
    public $receiver_id;

    public $type = 'UserTyping';

    public function __construct($chat_id, $receiver_id)
    {
        $this->chat_id = $chat_id;
        $this->receiver_id = $receiver_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->receiver_id);
    }

    public function broadcastAs()
    {
        return 'UserTyping'; // nombre más limpio
    }
}
