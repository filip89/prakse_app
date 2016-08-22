<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
	 * Middleware koji gleda jeli prijevljeni korisnik admin
     */
    public function handle($request, Closure $next)
    {
		
		if(!Auth::user()->isAdmin()){
			return response('Unauthorized. Only for admins.', 401);
		}
		
        return $next($request);
    }
}
