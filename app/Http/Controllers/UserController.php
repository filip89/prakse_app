<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;

use App\InternMentor;

use App\Company;

use Session;

use App\Internship;

use App\Competition;

use App\Utilities;

use DB;

use File;

class UserController extends Controller
{
	
	//
	public function __construct()
    {
		
		$this->middleware('auth');
		
		$this->middleware('admin', ['only' => [
			'admin',
        ]]);
		
		$this->middleware('adminOrSelfProfile', ['only' => [
            'editInternMentorForm',
            'editCollegeMentorForm',
			'editStudentForm',
			'editInternMentor',
            'editCollegeMentor',
			'editStudent',
			'deleteImage',
        ]]);
		
		$this->middleware('college_mentor', ['only' => [
			'internMentorIndex',
			'collegeMentorIndex',
			'studentIndex',
		]]);
		
		$this->middleware('profile_view', ['only' => [
			'viewProfile',
		]]);
		
		$this->middleware('user_internships', ['only' => [
			'userInternships',
		]]);
		
		$this->middleware('admin', ['only' => [
			'deleteUser',
			'index',
			'addInternMentor',
			'addInternMentorForm',
		]]);
				
		$this->middleware('student', ['only' => [
			'myInternship',
		]]);
		
    }
	
	//pregled usera po 'role'
	public function internMentorIndex(Request $request){
		
		if(isset($request->search)){
						
			$users = User::where('role', 'intern_mentor')->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', '%' . $request->search . '%')->paginate(30);
			
		}
		else{
			
		$users = User::where('role', 'intern_mentor')->paginate(30);
		
		}
		
		return view("intern_mentors", ['users' => $users]);
		
	}
	
	public function collegeMentorIndex(Request $request){
		
		if(isset($request->search)){
						
			$users = User::where('role', 'college_mentor')->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', '%' . $request->search . '%')->paginate(30);
			
		}
		else{
			
		$users = User::where('role', 'college_mentor')->paginate(30);
		
		}
		
		return view("college_mentors", ['users' => $users]);
		
	}
	
	public function studentIndex(Request $request){
		
		if(isset($request->search)){
						
			$users = User::where('role', 'student')->where(DB::raw("CONCAT(name, ' ', last_name)"), 'like', '%' . $request->search . '%')->paginate(30);
			
		}
		else{
			
			$users = User::where('role', 'student')->paginate(30);
			
		}
				
		return view("students", ['users' => $users]);
		
	}
	
	//pregled profila mentora
	public function viewProfile($id){
		
		$user = User::find($id);
		
		if($user->role == "college_mentor" || $user->role == "intern_mentor"){
			
			$currentCompInterns = $user->internships()->where('status', '<>', 0)->where('confirmation_admin', 1)->get();
				
			$recentInterns = $user->recentInternships();
			
			if($user->role == "college_mentor"){
			
				return view("profiles.college_mentor", ['user' => $user, 'currentCompInterns' => $currentCompInterns, 'recentInterns' => $recentInterns]);
			
			}
			else {
			
				return view("profiles.intern_mentor", ['user' => $user, 'currentCompInterns' => $currentCompInterns, 'recentInterns' => $recentInterns]);
			
			}
				
		}else {
			
			$lastInternship = $user->internships()->where('confirmation_admin', 1)->where('confirmation_student', 1)->orderBy('created_at', 'desc')->first();
			
			$applicsNum = count($user->applics()->get());
			
			$activeApplic = $user->applics()->where('status', '<>', 0)->first();
			
			$internshipsNum = count($user->internships()->where('confirmation_admin', 1)->where('confirmation_student', 1)->get());
			
			$internshipsTurnedDown = count($user->internships()->where('confirmation_admin', 1)->where('confirmation_student', 0)->get());
			
			
			return view("profiles.student", ['user' => $user, 'lastInternship' => $lastInternship, 'applicsNum' => $applicsNum, 'internshipsNum' => $internshipsNum, 'internshipsTurnedDown' => $internshipsTurnedDown]);
			
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
			'email' => 'required|email|max:255',
			'phone' => 'max:50',
			'title' => 'max:100',			
		]);
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->profile->title = $request->title;
		$user->profile->fields = $request->fields;
		$user->push();
		
		if(Auth::user()->id == $user->id){
			
			Session::flash('status', 'Profil vam je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		else{
			
			Session::flash('status', 'Korisnik je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		
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
				'email' => 'required|max:255',
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
			'email' => 'required|max:255',
			'job_descritpion' => 'max:5000',
			'phone' => 'max:50',
		]);
		}
		
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->profile->job_description = $request->job_description;
		
		if(Auth::user()->isAdmin()){
			$company = Company::find($request->company);
			$user->profile->company()->associate($company);
		}
		
		$user->push();
		
		if(Auth::user()->id == $user->id){
			
			Session::flash('status', 'Profil vam je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		else{
			
			Session::flash('status', 'Korisnik je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		
		return redirect("/user/" . $id);
		
	}
	
	//student
	public function editStudentForm($id){
		
		$user = User::find($id);
		
		return view("forms.student", ['user' => $user]);
		
	}
	
	public function editStudent(Request $request, $id){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'phone' => 'max:50',		
		]);
		
		$user = User::find($id);
		
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->save();
		
		if(Auth::user()->id == $user->id){
			
			Session::flash('status', 'Profil vam je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		else{
			
			Session::flash('status', 'Korisnik je uređen!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		
		return redirect("/user/" . $id);
		
	}
	
	
	//Dodavanje mentora iz tvrtke od strane admina
	
	public function addInternMentorForm($company_id = null){
		
		$companies = Company::all();
		
		return view("forms.register_mentor", ['companies' => $companies, 'selected' => $company_id]);
		
	}
	
	public function addInternMentor(Request $request){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'last_name' => 'required|max:255',
            'email' => 'email|max:255',
			'phone' => 'phone|max:50',
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
	
	public function myInternship(){
		
		$student = Auth::user();
		
		if($internship = $student->lastInternship()){
			
			return redirect('internships/' . $internship->id);	
			
		}
			
		return("Do sada niste imali niti jednu praksu.");
		
	}
	
	public function userInternships(Request $request, $id = null){
		
		if($id == null){
			
			$user = Auth::user();
			$id = $user->id;
			
		}
		else {
			
			$user = User::find($id);
			
		}
		
		$user_role_id = $user->role . '_id';
				
		if(isset($request->search)){
			
			if($user->role == 'student'){
				
				$internships = DB::table('internships')->join('users', 'internships.student_id', '=', 'users.id')->join('companies', 'internships.company_id', '=', 'companies.id')->join('competitions', 'internships.competition_id', '=', 'competitions.id')->select('internships.*', DB::raw("CONCAT(users.name, ' ', users.last_name) AS student_full_name"), 'companies.name AS company_name', 'companies.id AS company_id', 'competitions.created_at AS competition_created_at', 'competitions.name AS competition_name')->where($user_role_id, $id)->where('internships.status', 0)->where('internships.confirmation_student', 1)->where('internships.confirmation_admin', 1)->where('companies.name', 'like', '%' . $request->search . '%')->orderBy('internships.created_at', 'desc')->paginate(30);
				
			}
			else {
				
				$internships = DB::table('internships')->join('users', 'internships.student_id', '=', 'users.id')->join('companies', 'internships.company_id', '=', 'companies.id')->join('competitions', 'internships.competition_id', '=', 'competitions.id')->select('internships.*', DB::raw("CONCAT(users.name, ' ', users.last_name) AS student_full_name"), 'companies.name AS company_name', 'companies.id AS company_id', 'competitions.created_at AS competition_created_at', 'competitions.name AS competition_name')->where($user_role_id, $id)->where('internships.status', 0)->where('internships.confirmation_student', 1)->where('internships.confirmation_admin', 1)->where(function($query) use($request){
				
				$query->where(DB::raw("CONCAT(users.name, ' ', users.last_name)"), 'like', '%' . $request->search . '%')->orWhere('companies.name', 'like', '%' . $request->search . '%');
				
				}
		
				)->orderBy('internships.created_at', 'desc')->paginate(30);
				
			}

		}	
		else{
			
			$internships = DB::table('internships')->join('users', 'internships.student_id', '=', 'users.id')->join('companies', 'internships.company_id', '=', 'companies.id')->join('competitions', 'internships.competition_id', '=', 'competitions.id')->select('internships.*', DB::raw("CONCAT(users.name, ' ', users.last_name) AS student_full_name"), 'companies.name AS company_name', 'companies.id AS company_id', 'competitions.created_at AS competition_created_at', 'competitions.name AS competition_name')->where($user_role_id, $id)->where('internships.status', 0)->where('internships.confirmation_student', 1)->where('internships.confirmation_admin', 1)->orderBy('internships.created_at', 'desc')->paginate(30);

		}
		
		return view('user_internships', ['internships' => $internships, 'user' => $user]);
		
	}
	
	public function admin($id){
		
		$user = User::find($id);
		
		if($user->isAdmin()){
		
			$user->admin = 0;
			
			Session::flash('status', 'Korisnik više nije admin!');
			Session::flash('alert_type', 'alert-warning');
		
		}
		else {
			
			$user->admin = 1;
			
			Session::flash('status', 'Korisnik je postavljen kao admin!');
			Session::flash('alert_type', 'alert-success');
			
		}
		
		$user->save();
		
		if($user->id == Auth::user()->id){
			
			return redirect('/home');
			
		}
		
		return back();
	
	}
	
	public function addImage(Request $request){
		
		$this->validate($request, [
            'image_file' => 'required|max:10000|mimes:jpeg,png,bmp,gif',
		]);
		
		$user = Auth::user();
		
		if($user->image){
			
			$storedImage = $user->image;
			
			File::delete('images/profile/' . $storedImage);
			
		}
		
		$image = $request->file('image_file');

		$name = $user->id . $image->getClientOriginalName();
		$image->move('images/profile/', $name);
		
		$user->image = $name;
		$user->save();
		
		return redirect()->back();
		
	}
	
	public function deleteImage(Request $request, $id){
		
		$user = User::find($id);
		
		$storedImage = $user->image;
		
		File::delete('images/profile/' . $storedImage);
		
		$user->image = null;
		$user->save();
		
		return back();
		
	}
	
}
