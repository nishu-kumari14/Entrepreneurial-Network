<?php

namespace App\Policies;

use App\Models\ForumComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumCommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ForumComment $comment)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, ForumComment $comment)
    {
        return $user->id === $comment->user_id || $user->role === 'admin';
    }

    public function delete(User $user, ForumComment $comment)
    {
        return $user->id === $comment->user_id || $user->role === 'admin';
    }
} 