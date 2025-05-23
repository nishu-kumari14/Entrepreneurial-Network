<?php

namespace App\Services;

use App\Events\NotificationSent;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function sendProjectInvite(User $user, User $sender, $project)
    {
        $notification = Notification::create([
            'user_id' => $user->id,
            'sender_id' => $sender->id,
            'type' => 'project_invite',
            'message' => "{$sender->name} invited you to collaborate on {$project->title}",
            'data' => [
                'project_id' => $project->id,
                'project_title' => $project->title
            ]
        ]);

        event(new NotificationSent($notification));
    }

    public function sendMessageNotification(User $user, User $sender, $message)
    {
        $notification = Notification::create([
            'user_id' => $user->id,
            'sender_id' => $sender->id,
            'type' => 'new_message',
            'message' => "New message from {$sender->name}",
            'data' => [
                'message_id' => $message->id
            ]
        ]);

        event(new NotificationSent($notification));
    }

    public function sendForumReplyNotification(User $user, User $sender, $post, $comment)
    {
        $notification = Notification::create([
            'user_id' => $user->id,
            'sender_id' => $sender->id,
            'type' => 'forum_reply',
            'message' => "{$sender->name} replied to your forum post: {$post->title}",
            'data' => [
                'post_id' => $post->id,
                'comment_id' => $comment->id
            ]
        ]);

        event(new NotificationSent($notification));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
    }

    public function markAllAsRead(User $user)
    {
        $user->notifications()->whereNull('read_at')->update(['read_at' => now()]);
    }
} 