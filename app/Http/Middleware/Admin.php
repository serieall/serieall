<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->admin > 1){
            return $next($request);
        }

        return response('Vous n\'avez pas le droit d\'accéder à cette partie.', 401);
    }
}
