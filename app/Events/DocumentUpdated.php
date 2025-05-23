<?php

namespace App\Events;

use App\Models\DocumentCollaboration;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;
    public $user;
    public $action;
    public $content;

    public function __construct(DocumentCollaboration $document, User $user, string $action, ?string $content = null)
    {
        $this->document = $document;
        $this->user = $user;
        $this->action = $action;
        $this->content = $content;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('document.' . $this->document->id);
    }

    public function broadcastWith()
    {
        return [
            'document_id' => $this->document->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'action' => $this->action,
            'content' => $this->content,
            'timestamp' => now()->toISOString(),
        ];
    }
} 