<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Email;
use App\Models\Group;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use App\Policies\EmailPolicy;
use App\Policies\GroupPolicy;
use App\Policies\TaskPolicy;
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
            //
        Group::class => GroupPolicy::class,
        Task::class => TaskPolicy::class,
        Email::class => EmailPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('delete-task-comment', function (User $user, TaskComment $taskComment) {
            return $user->id == $taskComment->user_id;
        });
        Gate::define('view-task-option', function (User $user, $creator_id) {
            return $user->id == $creator_id;
        });
    }
}
