<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Message $message)
    {
        return $user->id === $message->sender_id || $user->id === $message->receiver_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Message $message)
    {
        return $user->id === $message->sender_id;
    }

    public function delete(User $user, Message $message)
    {
        return $user->id === $message->sender_id;
    }

    public function restore(User $user, Message $message)
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Message $message)
    {
        return $user->role === 'admin';
    }
} 