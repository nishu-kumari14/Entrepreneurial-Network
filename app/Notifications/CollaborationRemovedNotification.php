<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaborationRemovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Removed from Project: ' . $this->project->title)
            ->line('You have been removed as a collaborator from the project: ' . $this->project->title)
            ->line('If you believe this was a mistake, please contact the project owner.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'message' => 'You have been removed as a collaborator from the project: ' . $this->project->title,
            'type' => 'collaboration_removed',
            'url' => route('projects.show', $this->project),
        ];
    }
} 