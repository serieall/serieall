<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Auth\PasswordRepositoryManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider as IlluminatePasswordResetServiceProvider;

/**
 * Class PasswordResetServiceProvider.
 */
class PasswordResetServiceProvider extends IlluminatePasswordResetServiceProvider
{
    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordRepositoryManager($app);
        });
        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }
}
