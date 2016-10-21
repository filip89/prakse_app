<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CollegeMentorOrStudent
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

		if(Auth::user()->role != 'college_mentor'  || Auth::user()->role != 'student'){
			
			return 'Nemate dopušten pristup.';
			
		}

		return $next($request);
    }
}
