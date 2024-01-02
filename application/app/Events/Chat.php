<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $file;
    public $receiverId;
    public $senderId;
    public $createdAt;

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
         $this->message = $data->message;
         $this->file = $data->file;
         $this->receiverId = $data->receiverId;
         $this->senderId = $data->senderId;
         $this->createdAt = $data->createdAt;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat-channel'),
        ];
    }
    public function broadcastAs()
    {
        return $this->receiverId;
    }
}
