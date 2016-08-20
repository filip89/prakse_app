<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use App\User;

class ApplicController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('auth');
		
	}
	
	public function applyForm(){
		
		$user = Auth::user();
		
		return view("forms.application", ['user' => $user]);
		
	}
	
	public function apply($id){
		
		return User::find($id)->name;
		
	}
}
