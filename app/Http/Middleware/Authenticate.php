<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class Authenticate
{

    use AuthenticatesUsers;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        else
        {
            if ($request->user()->suspended == 1) {
                $this->guard()->logout();

                $request->session()->flush();

                $request->session()->regenerate();

                return redirect()
                    ->route('login')
                    ->with('warning', 'Votre compte a été bloqué.');
            }

            return $next($request);

        }
    }
}
