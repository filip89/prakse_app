<?php

namespace App\Http\Middleware;

use Closure;
use App\Competition;

class CompetitionActive
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
		
		if(Competition::current() == null){
			return('Nema otvorenog natječaja');
		}
		
        return $next($request);
    }
}
