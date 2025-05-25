<?php

namespace App\Policies;

use App\Models\Collaboration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollaborationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Collaboration $collaboration)
    {
        return $user->id === $collaboration->user_id ||
            $user->id === $collaboration->project->user_id ||
            $user->role === 'admin';
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Collaboration $collaboration)
    {
        return $user->id === $collaboration->project->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Collaboration $collaboration)
    {
        return $user->id === $collaboration->project->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Collaboration $collaboration)
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Collaboration $collaboration)
    {
        return $user->role === 'admin';
    }
} 