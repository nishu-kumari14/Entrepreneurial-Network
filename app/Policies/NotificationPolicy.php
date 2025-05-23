<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function markAsRead(User $user, Notification $notification)
    {
        return $user->id === $notification->user_id;
    }

    public function view(User $user, Notification $notification)
    {
        return $user->id === $notification->user_id;
    }
} 