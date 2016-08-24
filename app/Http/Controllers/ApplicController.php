<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Applic;
use App\Utilities;

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
		
		$applics = Applic::orderBy('created_at', 'asc')->get();
		
		return view('applics', ['applics' => $applics]);
		
	}
	
	public function myApplic(){
		
		$user = Auth::user();
		
		return view('myapplic');
		
	}
	
	/*
	public function applyForm(){
		
		$user = Auth::user();
		
		
		if(!$user->isAdmin()){
			
			return view("forms.application", ['user' => $user]);
			
		}
		else {
			
			//PROMijenit
			return view("forms.application", ['user' => $user]);
			
		}
		
	}
	*/
	
	public function applyForm($id = null){
		
		if(isset($id)){
			
			$user = User::find($id);
			
		}
		else {
			
			$user = Auth::user();
			
		}
		
		if(isset($user->applic)){
			
			return view("forms.application", ['user' => $user]);
			
		}
		else {
			
			return view("forms.application_empty", ['user' => $user]);
			
		}	
	
	}
	
	
	
	public function apply(Request $request, $id){
		
		$this->validate($request, [
			'academic_year' => 'required',
			'course' => 'required',
			'email' => 'required|max:100',
			'residence_town' => 'required|max:100',
			'residence_county' => 'required|max:100',
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
		//$applic->activities->sync($activities);
		
		/*
		$activities = $request->activities;
		$activitesChecked = array();
		
		
		for($i=1; $i<=10; $i++){
			
			if(isset($activities[$i])){
				
				$activitesChecked = $i + 1;
				
			}
			
		}
		
			$applic->activities->sync($activitiesPivot);
		
		foreach($i = 0; $i <= 9; $i++){
			
			if(isset($activities[$i])){
				
				
				$year = "year_" . ($i + 1);
				$description = "description_" . ($i + 1);
				
				if(isset($request->{$year})){
					
					$applic->activities()->updateExistingPivot();
					
				}
				if(isset($request->{$description})){
					
					
					
				}

			}
				
		}
		*/
		
		$user = User::find($id);
		$applic->student()->associate($user);
	
		
		$applic->save();
		
		if(Auth::user()->isAdmin){
			
			return redirect("/applics/all");
			
		}
		else{
			
			return redirect("/myapplic");
			
		}
		
		
	}
	
	public function delete($id){
		
		$user = User::find($id);
		
		$applic = $user->applic;
		
		$applic->delete();
		
		return back();	
		
	}
	
	
	public function edit(Request $request, $id){

		$this->validate($request, [
			'academic_year' => 'required',
			'course' => 'required',
			'email' => 'required|max:100',
			'residence_town' => 'required|max:100',
			'residence_county' => 'required|max:100',
		]);
		
		$user = User::find($id);
		
		$applic = $user->applic;
		
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
		
		if(Auth::user()->isAdmin()){
			
			return redirect("/applics/all");
			
		}
		else{
			
			return redirect("/myapplic");
			
		}
		
	}
	
}
