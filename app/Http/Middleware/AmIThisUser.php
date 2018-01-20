<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Auth;
use Closure;

/**
 * Class AmIThisUser
 * @package App\Http\Middleware
 */
class AmIThisUser
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
        $userIMustBe = $request->route('user');

        if($userIMustBe != Auth::user()->username) {
            return redirect()->back();
        }

        return $next($request);
    }
}
