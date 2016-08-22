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
            'editInternMentorForm',
            'editCollegeMentorForm',
        ]]);
		
		$this->middleware('admin', ['only' => [
			'deleteUser',
			'index',
		]]);
		
    }
	
	//pregled svih usera
	public function index(){
		
		$users = User::all();
		return view("users", ['users' => $users]);
		
	}
	
	//pregled profila mentora
	public function viewProfile($id){
				
		$user = User::find($id);
		
		if($user->role == "college_mentor"){
			
			return view("profiles.college_mentor", ['user' => $user]);
			
		}
		else {
			
			return view("profiles.intern_mentor", ['user' => $user]);
			
		}
		
	}
	
	public function deleteUser($id){
		
		$user = User::find($id);
		$user->delete();
		return back();
		
	}
	
	
	//Funkcije za mijenjanje info o mentoru nastavniku
	
	public function editCollegeMentorForm($id){
		
		$user = User::find($id);
		
		return view("forms.college_mentor", ['user' => $user]);
		
	}
	
	public function editCollegeMentor(Request $request, $id){
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->profile->title = $request->title;
		//$user->profile->fields()->sync([1,2]);
		$user->push();
		
		return redirect("/user/" . $id);
		
	}
	
	
	//Funkcije za mijenjanje info o mentoru sa prakse
	
	public function editInternMentorForm($id){
		
		$user = User::find($id);
		
		return view("forms.intern_mentor", ['user' => $user]);
		
	}
	
	public function editInternMentor(Request $request, $id){
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->profile->job_description = $request->job_description;
		$user->profile->phone = $request->phone;
		//company
		$user->push();
		
		return redirect("/user/" . $id);
		
	}
}
