<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaborationResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $accepted;

    public function __construct(Project $project, bool $accepted)
    {
        $this->project = $project;
        $this->accepted = $accepted;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Collaboration Request ' . ($this->accepted ? 'Accepted' : 'Rejected'))
            ->line('Your request to collaborate on project "' . $this->project->title . '" has been ' . 
                  ($this->accepted ? 'accepted' : 'rejected') . '.');

        if ($this->accepted) {
            $message->action('View Project', route('projects.show', $this->project))
                   ->line('You can now collaborate on the project!');
        }

        return $message;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'message' => 'Your collaboration request for "' . $this->project->title . '" has been ' . 
                        ($this->accepted ? 'accepted' : 'rejected'),
            'type' => 'collaboration_response',
            'status' => $this->accepted ? 'accepted' : 'rejected',
            'url' => route('projects.show', $this->project),
        ];
    }
} 