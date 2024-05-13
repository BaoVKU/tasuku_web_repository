<?php

namespace App\Providers;

use App\Services\UserActivityService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class UserActivityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserActivityService::class, function ($app) {
            return new UserActivityService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
