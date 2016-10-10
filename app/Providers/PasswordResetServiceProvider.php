<?php

namespace App\Providers;

use App\Repositories\Auth\PasswordRepository;

class PasswordResetServiceProvider extends \Illuminate\Auth\Passwords\PasswordResetServiceProvider
{

    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            $tokens = $app['auth.password.tokens'];

            $users = $app['auth']->driver()->getProvider();

            $view = $app['config']['auth.password.email'];

            return new PasswordBroker(
                $tokens, $users, $app['mailer'], $view
            );
        });
    }

}