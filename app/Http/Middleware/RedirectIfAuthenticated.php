<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
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
        if (Auth::guard($guard)->check() && (Auth::user()->user_role->slug == "superadmin" || Auth::user()->user_role->slug == "admin" || Auth::user()->user_role->slug == "stuff") && Auth::user()->status == 1 ) {
            return $next($request);
        }

        else if (Auth::guard($guard)->check() && Auth::user()->user_role->slug == "customer" && Auth::user()->status == 1 ) {
            return redirect('/home');
        }

        return $next($request);
    }
}
