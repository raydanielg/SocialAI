<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Reply as ModelsReply;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Reply implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $connection = 'sync';
    private User $sender;
    private ModelsReply $reply;
    private Conversation $conversation;
    /**
     * Create a new event instance.
     */
    public function __construct(User $sender, ModelsReply $reply, Conversation $conversation)
    {
        $this->sender = $sender;
        $this->reply = $reply;
        $this->conversation = $conversation;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->reply->id,
            'body' => $this->reply->body,
            'attachments' => $this->reply->attachments,
            'conversation_id' => $this->conversation->id,
            'created_at' => $this->reply->created_at,
            'user' => [
                'avatar' => $this->sender->avatar,
                'name' => $this->sender->name,
                'id' => $this->sender->id,
            ],
            'user_id' => $this->sender->id,
        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('reply.' . $this->conversation->uuid),
        ];
    }
}
