<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserInternships
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
		
       	$userViewed = User::find($request->route('id'));
		$userViewing =  Auth::user();
		
		if($userViewing->role == 'college_mentor'){
			
			return $next($request);
			
		}
		
		if($userViewing->role == 'student' && $userViewing->id == $userViewed->id){
			
			return $next($request);		
			
		}
		
		if($userViewing->role == 'intern_mentor' && $userViewed->role == 'intern_mentor' && $userViewing->profile->company->id == $userViewed->profile->company->id){
			
			return $next($request);
			
		}
		
		return "Not allowed";
    }
}
