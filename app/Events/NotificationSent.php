<?php

namespace App\Events;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $conversation;
    public $receiver;
    public $instruction;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  string  $message
     * @param  string  $conversation
     * @param  mixed  $receiver
     * @return void
     */
    public function __construct($user, $message, $conversation, $instruction, $receiver)
    {
        $this->user = $user;
        $this->message = $message;
        $this->conversation = $conversation;
        $this->receiver = $receiver;
        $this->instruction = $instruction;

            Notification::create([
                'instruction_id' => $instruction,
                'user_id' => $user,
                'message' => $message,
                'conversation' => $conversation,
                'receiver_id' => $receiver,
            ]);
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notif.'. $this->receiver);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'instruction_id' => $this->instruction,
            'user_id' => $this->user,
            'message' => $this->message,
            'conversation_id' => $this->conversation,
            'receiver_id' => $this->receiver,
        ];
    }
}
