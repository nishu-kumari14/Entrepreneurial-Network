<?php

namespace App\Events;

use App\Models\Skill;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SkillUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $skill;
    public $userId;

    public function __construct(Skill $skill, $userId)
    {
        $this->skill = $skill;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'skill' => [
                'id' => $this->skill->id,
                'name' => $this->skill->name,
                'category' => $this->skill->category,
                'users_count' => $this->skill->users()->count(),
            ]
        ];
    }
} 