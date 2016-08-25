<?php

namespace App\Http\Middleware;

use Closure;

class IsAuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $user)
    {
        if ($request->user()->id == $user->id)
        return $next($request);
    }
}
