<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\PasswordRepository;
use Illuminate\Auth\Passwords\PasswordBrokerManager as IlluminatePasswordBrokerManager;

class PasswordRepositoryManager extends IlluminatePasswordBrokerManager
{
    /**
     * Resolve the given broker.
     *
     * @param  string $name
     * @return PasswordRepository
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        if (is_null($config)) {
            throw new InvalidArgumentException("Password resetter [{$name}] is not defined.");
        }
        // The password broker uses a token repository to validate tokens and send user
        // password e-mails, as well as validating that password reset process as an
        // aggregate service of sorts providing a convenient interface for resets.
        return new PasswordRepository(
            $this->createTokenRepository($config),
            $this->app['auth']->createUserProvider($config['provider']),
            $this->app['mailer'],
            $config['email']
        );
    }
}