<?php

namespace App\Repositories\Auth;

use \Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\PasswordBroker as IlluminatePasswordBroker;

class PasswordRepository extends IlluminatePasswordBroker
{
    /**
     * Envoi un email pour le reset du mot de passe
     *
     * @param CanResetPassword $user
     * @param $token
     * @param \Closure|null $callback
     * @return mixed
     */
    public function emailResetLink(CanResetPassword $user, $token, \Closure $callback = null)
    {
        // We will use the reminder view that was given to the broker to display the
        // password reminder e-mail. We'll pass a "token" variable into the views
        // so that it may be displayed for an user to click for password reset.
        $view = $this->emailView;

        return $this->mailer->queue($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForPasswordReset());
            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }
}