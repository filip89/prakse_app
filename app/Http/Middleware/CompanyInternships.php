<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Company;

class CompanyInternships
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
		
       	$company = Company::find($request->route('id'));
		$userViewing =  Auth::user();
		
		if($userViewing->role == 'college_mentor'){
			
			return $next($request);
			
		}
		
		if($userViewing->role == 'intern_mentor' && $userViewing->profile->company->id == $company->id){
			
			return $next($request);
			
		}
		
		return "Not allowed";
    }
}
