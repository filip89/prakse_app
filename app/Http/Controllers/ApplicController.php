<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Applic;
use App\Utilities;
use App\Activity;
use Session;

class ApplicController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('auth');
		
		$this->middleware('admin', ['only' => [
			'index',
		]]);
		
		$this->middleware('adminOrAuth', ['only' => [
			'apply',
			'delete',
			'edit',
		]]);
		
		$this->middleware('student', ['only' => [
			'myApplic',
		]]);
		
		
	}
	
	public function index() {
		
		$applics = Applic::where('status', 1)->orderBy('created_at', 'asc')->paginate(1);
		
		return view('applics', ['applics' => $applics]);
		
	}
	
	public function myApplic(){
		
		$user = Auth::user();
		
		/*
		if(count($user->applics) == 0){
			
			return redirect('/apply');
	
		}
		*/
		
		if(count($user->applics()->where("status", ">", 0)->get()) == 0){
				
				return redirect('/apply');
				
		}

		//$applic = $user->applics()->where("status", "<>", 0)->first();
		
		$applic = $user->applics()->orderBy('created_at', 'desc')->first();

		$activities = $applic->activities;
		
		return view('myapplic', ['applic' => $applic, 'user' => $user, 'activities' => $activities]);
		
	}
	
	
	public function applyForm($id = null){
		
		if(isset($id)){
		
			$user = User::find($id);	
			
		}
		else {
			
			$user = Auth::user();
			
		}
		
		if($applic = $user->applics()->where("status", "=", 1)->first()){
			
			$activities = array(array('name' => '', 'checked' => '','year' => '','description' => ''));
			
			for($i=1; $i<=10; $i++){
				
				if($applic->activities->where('number', $i)->first() !== null){
					$activity = $applic->activities->where('number', $i)->first();
					$checked = 'checked';
					$year = $activity->year;
					$description = $activity->description;
				}
				else {
					$checked = '';
					$year = '';
					$description = '';
				}
				
				
				$activities[$i] = array('name' => Utilities::activity($i),'checked' =>  $checked, 'year' => $year, 'description' => $description);
								
			}
			
			return view("forms.application", ['user' => $user, 'applic' => $applic, 'activities' => $activities]);
			
		}
		else {
			
			for($i=1; $i<=10; $i++){
				
				$activities[$i] = Utilities::activity($i);
				
			}
			
			
			return view("forms.application_empty", ['user' => $user, 'activities' => $activities]);
			
		}	
	
	}
	
	
	
	public function apply(Request $request, $id){
		
		$user = User::find($id);
		
		$this->validate($request, [
			'academic_year' => 'required',
			'course' => 'required',
			'email' => 'required|max:100',
			'residence_town' => 'required|max:100',
			'residence_county' => 'required|max:100',
			'internship_town' => 'max:100',
			'desired_town' => 'max:100',
			'average_bacc_grade' => 'between:0,5'
		]);
		
		$applic = new Applic;
		
		$applic->academic_year = $request->academic_year;
		$applic->course = $request->course;
		$applic->email = $request->email;
		$applic->average_bacc_grade = $request->average_bacc_grade;
		$applic->average_master_grade = $request->average_master_grade;
		$applic->desired_company = $request->desired_company;
		$applic->desired_month = $request->desired_month;
		$applic->internship_town = $request->internship_town;
		$applic->residence_town = $request->residence_town;
		$applic->residence_county = $request->residence_county;
						
		$applic->student()->associate($user);
		$applic->save();
		
		
		for($i=1; $i<=10; $i++){
			
			if(isset($request->activities[$i])){
				
				$activity = new Activity;
				$activity->number = $i;
				$year = 'year_' . $i;
				$description = 'description_' . $i;
				
				if(isset($request->$year)){
					$activity->year = $request->$year;
				}
				
				if(isset($request->$description)){
					$activity->description = $request->$description;
				}

				$activity->applic()->associate($applic);
				$activity->save();
			}
		
		}
		
		Session::flash('status', 'Prijava je izrađena!');
		Session::flash('alert_type', 'alert-success');
		
		if(Auth::user()->isAdmin()){
			
			return redirect("/applic/all");
			
		}
		else{
			
			return redirect("/myapplic");
			
		}
		
		
	}
	
	public function delete($id){
		
		$user = User::find($id);
		
		if($applic = $user->applics()->where("status", "=", 1)->first()){
			
			$applic->delete();
		
			Session::flash('status', 'Prijava je obrisana! Ukoliko želite možete napraviti novu prije kraja natječaja.');
			Session::flash('alert_type', 'alert-danger');
			
			return back();
			
		}	
		
	}
	
	
	public function edit(Request $request, $id){

		$this->validate($request, [
			'academic_year' => 'required',
			'course' => 'required',
			'email' => 'required|max:100|email',
			'residence_town' => 'required|max:100',
			'residence_county' => 'required|max:100',
		]);
		
		$user = User::find($id);
		
		$applic = $user->applics()->where("status", "=", 1)->first();
		
		$applic->academic_year = $request->academic_year;
		$applic->course = $request->course;
		$applic->email = $request->email;
		$applic->average_bacc_grade = $request->average_bacc_grade;
		$applic->average_master_grade = $request->average_master_grade;
		$applic->desired_company = $request->desired_company;
		$applic->desired_month = $request->desired_month;
		$applic->internship_town = $request->internship_town;
		$applic->residence_town = $request->residence_town;
		$applic->residence_county = $request->residence_county;
		
		$applic->save();
		
		$applic->activities()->delete();
		
		for($i=1; $i<=10; $i++){
			
			if(isset($request->activities[$i])){
				
				$activity = new Activity;
				$activity->number = $i;
				$year = 'year_' . $i;
				$description = 'description_' . $i;
				
				if(isset($request->$year)){
					$activity->year = $request->$year;
				}
				
				if(isset($request->$description)){
					$activity->description = $request->$description;
				}

				$activity->applic()->associate($applic);
				$activity->save();
			}
		
		}
		
		Session::flash('status', 'Prijava je izmijenjena!');
		Session::flash('alert_type', 'alert-warning');
		
		if(Auth::user()->isAdmin()){
			
			return redirect("/user/student/list");
			
		}
		else{
			
			return redirect("/myapplic");
			
		}
		
	}
	
}
