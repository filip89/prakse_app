<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\InternMentor;

use App\CollegeMentor;

use App\Field;

class UserController extends Controller
{
	
	//
	//Postavljanje middlewarea 'auth', ali i 'admin' i "thisUser" za specifične funkcije
	public function __construct()
    {
		
		$this->middleware('auth');
		
		$this->middleware('adminOrAuth', ['only' => [
            'editMentorForm',
        ]]);
		
    }
	
	public function index(){
		
		$users = User::all();
		return view("users", ['users' => $users]);
		
	}
	
	public function deleteUser($id){
		
		$user = User::find($id);
		$user->delete();
		return back();
		
	}
	
	public function viewProfile($id){
		
		//???
		/*
		if(Auth::user()->id != $id && !Auth::user()->isAdmin()){
			return redirect("/home");
		}
		*/
		
		$user = User::find($id);
		
		if($user->role == "college_mentor"){
			
			return view("college_profile", ['user' => $user]);
			
		}
		else {
			
			return view("intern_profile", ['user' => $user]);
			
		}
		
	}
	
	
	//Uređivanje profila za mentore
	
	public function editMentor(Request $request, $id){
		
		$user = User::find($id);
		
		if($user->role == "college_mentor"){
			
			self::editCollegeMentor($request, $user);
			
		}
		else{
			
			self::editInternMentor($request, $user);
			
		}
	
	}
	
	private static function editCollegeMentor(Request $request, $id){
		
		//...
		$user = User::find($id);
		
		return "user/" . $user->id;
		
	}
	
	private static function editInternMentor(Request $request, User $user){
		
		//...
		
		return "user/" . $user->id;
		
	}
	
	//Forma za profile mentora
	
	public function editMentorForm($id){
		
		$user = User::find($id);
		
		if($user->role == "college_mentor"){
			
			return view("forms.college_mentor", ['user' => $user]);
			
		}
		else{
			
			return view("forms.intern_mentor", ['user' => $user]);
			
		}	
	}
	
}
