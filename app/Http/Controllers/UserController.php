<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;

use App\InternMentor;

use App\Company;

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
			'addInternMentor',
			'addInternMentorForm',
		]]);
		
		$this->middleware('mentor', ['only' => [
			'viewProfile',
		]]);
		
    }
	
	//pregled usera po 'role'
	public function internMentorIndex(){
		
		$users = User::where('role', 'intern_mentor')->get();
		
		return view("intern_mentors", ['users' => $users]);
		
	}
	
	public function collegeMentorIndex(){
		
		$users = User::where('role', 'college_mentor')->get();
		return view("college_mentors", ['users' => $users]);
		
	}
	
	public function studentIndex(){
		
		$users = User::where('role', 'student')->get();
		return view("students", ['users' => $users]);
		
	}
	
	//pregled profila mentora
	public function viewProfile($id){
		
		$user = User::find($id);
		$internships = $user->internships;
		
		if(!isset($user)){
			
			return ('No such user.');
			
		}
		
		if($user->role == "college_mentor"){
				
			return view("profiles.college_mentor", ['user' => $user, 'internships' => $internships]);
			
		}
		else {
			
			return view("profiles.intern_mentor", ['user' => $user, 'internships' => $internships]);
			
		}
		
	}
	
	public function deleteUser($id){
		
		$user = User::find($id);
		$user->delete();
		return redirect('/home');
		
	}
	
	
	//Funkcije za mijenjanje info o mentoru nastavniku
	
	public function editCollegeMentorForm($id){
		
		$user = User::find($id);
		
		return view("forms.college_mentor", ['user' => $user]);
		
	}
	
	public function editCollegeMentor(Request $request, $id){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'last_name' => 'required|max:255',
		]);
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->profile->title = $request->title;
		$user->profile->fields = $request->fields;
		$user->push();
		
		return redirect("/user/" . $id);
		
	}
	
	
	//Funkcije za mijenjanje info o mentoru sa prakse
	
	public function editInternMentorForm($id){
		
		$user = User::find($id);
	
		$companies = Company::all();
		
		return view("forms.intern_mentor", ['user' => $user, 'companies' => $companies]);
		
	}
	
	public function editInternMentor(Request $request, $id){
		
	if(Auth::user()->isAdmin()){
			$this->validate($request, [
				'name' => 'required|max:255',
				'last_name' => 'required|max:255',
				'job_descritpion' => 'max:5000',
				'phone' => 'max:50',
				'company' => 'required',
			]);
		}
		else{
			$this->validate($request, [
            'name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'job_descritpion' => 'max:5000',
			'phone' => 'max:50',
		]);
		}
		
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->profile->job_description = $request->job_description;
		$user->profile->phone = $request->phone;
		$user->push();
		
		if(Auth::user()->isAdmin()){
			$company = Company::find($request->company);
			$user->profile->company()->associate($company);
		}
		
		$user->profile->save();
		
		return redirect("/user/" . $id);
		
	}
	
	
	//Dodavanje mentora iz tvrtke od strane admina
	
	public function addInternMentorForm($id = null){
		
		$companies = Company::all();
		
		return view("forms.register_mentor", ['companies' => $companies, 'selected' => $id]);
		
	}
	
	public function addInternMentor(Request $request){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
			'company' => 'required'
		]);
		
		$user = User::create([
			'name' => $request->name,
			'last_name' => $request->last_name,
            'email' => $request->email,
			'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
		
		$mentor = InternMentor::create([
			'user_id' => $user->id,
        ]);
		
		$company = Company::find($request->company);
		$mentor->company()->associate($company);
		$mentor->save();
		
		return redirect("company/profile/" . $company->id);
		
	}
	
}
