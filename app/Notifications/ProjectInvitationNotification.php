<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProjectInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $inviter;
    protected $role;

    public function __construct($project, $inviter, $role)
    {
        $this->project = $project;
        $this->inviter = $inviter;
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
            'inviter_avatar' => $this->inviter->avatar_url,
            'role' => $this->role,
            'message' => "{$this->inviter->name} invited you to join {$this->project->title} as {$this->role}",
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
            'inviter_avatar' => $this->inviter->avatar_url,
            'role' => $this->role,
            'message' => "{$this->inviter->name} invited you to join {$this->project->title} as {$this->role}",
        ]);
    }
} 