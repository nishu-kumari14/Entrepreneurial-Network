<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProjectNotification extends Notification implements ShouldQueue
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
            ->subject('New Project Posted: ' . $this->project->title)
            ->line('A new project has been posted that might interest you.')
            ->line('Project Title: ' . $this->project->title)
            ->line('Required Skills: ' . implode(', ', $this->project->skills_required))
            ->action('View Project', route('projects.show', $this->project))
            ->line('Check it out if you\'re interested in collaborating!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'title' => $this->project->title,
            'message' => 'New project posted: ' . $this->project->title,
            'type' => 'new_project',
            'url' => route('projects.show', $this->project),
        ];
    }
} 