<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;
    public $roomId;
    public $fromId;
    public $status;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$user,$roomId,$fromId,$status)
    {
        $this->message = $message;
        $this->user = $user;
        $this->roomId = $roomId;
        $this->fromId = $fromId;
        $this->status = $status;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('message.'.$this->roomId);
    }
    public function broadcastAs()
    {
        return 'chat-message';
    }
    public function broadcastWith()
    {
        return [
            'id'=>$this->fromId,
            'name'=>$this->user,
            'message'=>$this->message,
            'status'=>$this->status,
        ];
    }
}
