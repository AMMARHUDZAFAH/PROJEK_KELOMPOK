<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the 'role' alias to resolve to the RoleMiddleware instance.
        // Use a closure so the container builds the real middleware class.
        $this->app->bind('role', function ($app) {
            return $app->make(\App\Http\Middleware\RoleMiddleware::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
