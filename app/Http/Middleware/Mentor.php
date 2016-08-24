<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Mentor
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
		if(Auth::user()->role != "intern_mentor" && Auth::user()->role != "college_mentor"){
			
			return "Only for mentors";
			
		}
		
        return $next($request);
    }
}
