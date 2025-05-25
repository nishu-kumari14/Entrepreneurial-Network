<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $timeUntilEvent;

    public function __construct($event, $timeUntilEvent)
    {
        $this->event = $event;
        $this->timeUntilEvent = $timeUntilEvent;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'event_start_time' => $this->event->start_time,
            'event_location' => $this->event->location,
            'time_until_event' => $this->timeUntilEvent,
            'message' => "Reminder: {$this->event->title} starts in {$this->timeUntilEvent}",
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'event_start_time' => $this->event->start_time,
            'event_location' => $this->event->location,
            'time_until_event' => $this->timeUntilEvent,
            'message' => "Reminder: {$this->event->title} starts in {$this->timeUntilEvent}",
        ]);
    }
} 