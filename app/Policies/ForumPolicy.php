<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Forum $forum)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Forum $forum)
    {
        return $user->id === $forum->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Forum $forum)
    {
        return $user->id === $forum->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Forum $forum)
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Forum $forum)
    {
        return $user->role === 'admin';
    }
} 