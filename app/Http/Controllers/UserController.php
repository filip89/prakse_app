<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;

use App\InternMentor;

use App\Company;

use Session;

class UserController extends Controller
{
	
	//
	//Postavljanje middlewarea 'auth', ali i 'admin' i "thisUser" za specifične funkcije
	public function __construct()
    {
		
		$this->middleware('auth');
		
		$this->middleware('adminOrSelf', ['only' => [
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
		
		$users = User::where('role', 'intern_mentor')->paginate(1);
		
		return view("intern_mentors", ['users' => $users]);
		
	}
	
	public function collegeMentorIndex(){
		
		$users = User::where('role', 'college_mentor')->paginate(1);
		return view("college_mentors", ['users' => $users]);
		
	}
	
	public function studentIndex(){
		
		$users = User::where('role', 'student')->paginate(1);
				
		return view("students", ['users' => $users]);
		
	}
	
	//pregled profila mentora
	public function viewProfile($id){
		
		$user = User::find($id);
		$internships = $user->internships()->where('status', '<>', 0)->where(function($query){ return $query->where('confirmation_student', "=", null)->orWhere('confirmation_student', "=", 1);})->get();
		
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
		
		Session::flash('status', 'Korisnik je izbrisan!');
		Session::flash('alert_type', 'alert-danger');
		
		if($user->role == "intern_mentor"){
			
			return redirect('/user/intern_mentor/list');
			
		}
		elseif($user->role == "college_mentor"){
			
			return redirect('/user/college_mentor/list');
			
		}
		elseif($user->role == "student"){
			
			return redirect('/user/student/list');
			
		}
		
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
		
		Session::flash('status', 'Korisnik je uređen!');
		Session::flash('alert_type', 'alert-warning');
		
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
		
		
		if(Auth::user()->isAdmin()){
			$company = Company::find($request->company);
			$user->profile->company()->associate($company);
		}
		
		$user->push();
		
		Session::flash('status', 'Korisnik je uređen!');
		Session::flash('alert_type', 'alert-warning');
		
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
		
		$user = new User;
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->role = $request->role;
		$user->password = bcrypt($request->password);
		$user->save();
		
		$company = Company::find($request->company);
		
		$mentor = new InternMentor;
		$mentor->company()->associate($company);
		$mentor->user()->associate($user);	
		
		$mentor->save();
		
		Session::flash('status', 'Korisnik je dodan!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect("company/profile/" . $company->id);
		
	}
	
}
