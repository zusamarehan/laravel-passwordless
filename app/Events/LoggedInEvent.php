<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedInEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $cookie;

    /**
     * Create a new event instance.
     *
     * @param $user_id
     * @param $cookie
     */
    public function __construct($user_id, $cookie)
    {
        $this->user_id = $user_id;
        $this->cookie = $cookie;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
