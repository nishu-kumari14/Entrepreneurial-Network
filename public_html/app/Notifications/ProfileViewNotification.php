<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProfileViewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $viewer;
    protected $viewedAt;

    public function __construct($viewer)
    {
        $this->viewer = $viewer;
        $this->viewedAt = now();
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'viewer_id' => $this->viewer->id,
            'viewer_name' => $this->viewer->name,
            'viewer_avatar' => $this->viewer->avatar_url,
            'viewed_at' => $this->viewedAt,
            'message' => "{$this->viewer->name} viewed your profile",
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'viewer_id' => $this->viewer->id,
            'viewer_name' => $this->viewer->name,
            'viewer_avatar' => $this->viewer->avatar_url,
            'viewed_at' => $this->viewedAt,
            'message' => "{$this->viewer->name} viewed your profile",
        ]);
    }
} 