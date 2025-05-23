<?php

namespace App\Events;

use App\Models\Collaboration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaborationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $collaboration;
    public $userId;

    public function __construct(Collaboration $collaboration, $userId)
    {
        $this->collaboration = $collaboration;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'collaboration' => [
                'id' => $this->collaboration->id,
                'project_id' => $this->collaboration->project_id,
                'status' => $this->collaboration->status,
                'project' => [
                    'title' => $this->collaboration->project->title,
                    'description' => $this->collaboration->project->description,
                ]
            ]
        ];
    }
} 