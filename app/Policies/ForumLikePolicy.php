<?php

namespace App\Policies;

use App\Models\ForumLike;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumLikePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ForumLike $like)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasVerifiedEmail();
    }

    public function delete(User $user, ForumLike $like)
    {
        return $user->id === $like->user_id;
    }
} 