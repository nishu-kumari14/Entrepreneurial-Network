<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ForumPost $post)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, ForumPost $post)
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    public function delete(User $user, ForumPost $post)
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    public function pin(User $user, ForumPost $post)
    {
        return $user->role === 'admin';
    }

    public function lock(User $user, ForumPost $post)
    {
        return $user->role === 'admin';
    }
} 