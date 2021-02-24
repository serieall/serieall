<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

/**
 * Class Authenticate.
 */
class Authenticate
{
    use AuthenticatesUsers;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        } else {
            if (1 == $request->user()->suspended) {
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
