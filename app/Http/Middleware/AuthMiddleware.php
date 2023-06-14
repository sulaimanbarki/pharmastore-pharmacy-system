<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthMiddleware
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
        if(Auth::check() && (Auth::user()->user_role->slug == "superadmin" || Auth::user()->user_role->slug == "admin" || Auth::user()->user_role->slug == "stuff") && Auth::user()->status == 1 ){

            return $next($request);
        }else{

            return redirect()->route('login');
        }
        
    }
}
