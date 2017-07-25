<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
        Log::info($request->user()->username . ' passe par le middleware admin.');

        if ($request->user()->role < 4){
            Log::info($request->user()->username . ' a été accepté par le middleware admin');
            return $next($request);
        }

        return redirect()->back();
    }
}
