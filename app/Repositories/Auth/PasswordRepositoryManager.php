<?php
declare(strict_types=1);

namespace App\Repositories\Auth;

use Closure;
use Psr\Log\InvalidArgumentException;
use Illuminate\Auth\Passwords\PasswordBrokerManager as IlluminatePasswordBrokerManager;

/**
 * Class PasswordRepositoryManager
 * @package App\Repositories\Auth
 */
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
        if ($config === null) {
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

    /**
     * Send a password reset link to a user.
     *
     * @param  array $credentials
     * @return string
     */
    public function sendResetLink(array $credentials)
    {
        // TODO: Implement sendResetLink() method.
    }

    /**
     * Reset the password for the given token.
     *
     * @param  array $credentials
     * @param  \Closure $callback
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback)
    {
        // TODO: Implement reset() method.
    }

    /**
     * Set a custom password validator.
     *
     * @param  \Closure $callback
     * @return void
     */
    public function validator(Closure $callback)
    {
        // TODO: Implement validator() method.
    }

    /**
     * Determine if the passwords match for the request.
     *
     * @param  array $credentials
     * @return void
     */
    public function validateNewPassword(array $credentials)
    {
        // TODO: Implement validateNewPassword() method.
    }
}