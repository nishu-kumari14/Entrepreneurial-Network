<?php

namespace App\Policies;

use App\Models\ForumCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ForumCategory $category)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ForumCategory $category)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ForumCategory $category)
    {
        return $user->role === 'admin';
    }
} 