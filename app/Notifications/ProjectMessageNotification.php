<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Message in Project: ' . $this->message->project->title)
            ->line($this->message->user->name . ' sent a message in project: ' . $this->message->project->title)
            ->line($this->message->content)
            ->action('View Project', route('projects.show', $this->message->project));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'project_id' => $this->message->project->id,
            'project_title' => $this->message->project->title,
            'sender_id' => $this->message->user->id,
            'sender_name' => $this->message->user->name,
            'content' => $this->message->content,
            'type' => 'project_message',
            'url' => route('projects.show', $this->message->project),
        ];
    }
} 