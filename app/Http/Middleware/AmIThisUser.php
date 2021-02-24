<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Auth;
use Closure;

/**
 * Class AmIThisUser.
 */
class AmIThisUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userIMustBe = $request->route('user');

        if (strtolower($userIMustBe) != strtolower(Auth::user()->username)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
