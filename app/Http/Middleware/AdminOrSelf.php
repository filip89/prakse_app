<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOrSelf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
	 * Middleware koji gleda jeli prijevljeni korisnik admin ili onaj o čijem profilu se radi
     */
    public function handle($request, Closure $next)
    {

		if(!Auth::user()->isAdmin() && Auth::user()->id != $request->route('id')){

				return response('Unauthorized. You have to be admin or this user.', 401);

		}
				
        return $next($request);
    }
}
