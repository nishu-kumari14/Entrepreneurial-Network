<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Collaboration;
use App\Models\Forum;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\CollaborationPolicy;
use App\Policies\ForumPolicy;
use App\Policies\MessagePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Comment::class => CommentPolicy::class,
        Collaboration::class => CollaborationPolicy::class,
        Forum::class => ForumPolicy::class,
        Message::class => MessagePolicy::class,
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define admin gate
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
} 