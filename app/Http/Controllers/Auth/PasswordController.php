<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Closure;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Votre lien de réinitialisation de mot de passe';
    }


    /**
     * Send the password reset link via e-mail.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return int
     */
    public function emailResetLink(CanResetPasswordContract $user, $token, Closure $callback = null)
    {
        // We will use the reminder view that was given to the broker to display the
        // password reminder e-mail. We'll pass a "token" variable into the views
        // so that it may be displayed for an user to click for password reset.
        $view = $this->emailView;

        Log::info('test');

        return $this->mailer->queue($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForPasswordReset());

            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }
}
