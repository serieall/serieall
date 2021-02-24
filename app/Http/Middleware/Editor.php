<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class Admin.
 */
class Editor
{
    use AuthenticatesUsers;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role < 3) {
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

        return redirect()->back();
    }
}
