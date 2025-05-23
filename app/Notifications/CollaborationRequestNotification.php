<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaborationRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $requester;

    public function __construct(Project $project, User $requester)
    {
        $this->project = $project;
        $this->requester = $requester;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Collaboration Request')
            ->line($this->requester->name . ' has requested to collaborate on your project: ' . $this->project->title)
            ->action('View Project', route('projects.show', $this->project))
            ->line('You can accept or reject this request from the project page.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'requester_id' => $this->requester->id,
            'requester_name' => $this->requester->name,
            'message' => $this->requester->name . ' has requested to collaborate on your project: ' . $this->project->title,
            'type' => 'collaboration_request',
            'url' => route('projects.show', $this->project),
        ];
    }
} 