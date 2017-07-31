<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class Banned
{
    use AuthenticatesUsers;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info($request->user()->username . ' passe par le middleware Banned.');

        if ($request->user()->suspended == 1) {
            Log::info($request->user()->username . ' est banni. On le déconnecte et on lui explique pourquoi.');

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
