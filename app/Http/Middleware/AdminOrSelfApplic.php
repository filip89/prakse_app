<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Applic;

class AdminOrSelfApplic
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
		
		if(isset(Auth::user()->activeApplic()->id)){
			
			$applicId = Auth::user()->activeApplic()->id;
			
		}

		if(!Auth::user()->isAdmin() && $applicId != $request->route('id')){

				return response('Unauthorized. You have to be admin or this user.', 401);

		}
				
        return $next($request);
    }
}
