<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender;
    protected $message;
    protected $conversationId;

    public function __construct($sender, $message, $conversationId)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->conversationId = $conversationId;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->avatar_url,
            'message' => $this->message,
            'conversation_id' => $this->conversationId,
            'preview' => str_limit($this->message, 100),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->avatar_url,
            'message' => $this->message,
            'conversation_id' => $this->conversationId,
            'preview' => str_limit($this->message, 100),
        ]);
    }
} 