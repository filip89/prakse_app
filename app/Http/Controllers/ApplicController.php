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
use App\Competition;
use DB;

class ApplicController extends Controller
{
    //
	
	public function __construct(){
				
		$this->middleware('auth');
		
		$this->middleware('college_mentor', ['only' => [
			'index',
			'former',
			'view',
		]]);
		
		$this->middleware('adminOrSelfApplic', ['only' => [
			'delete',
		]]);
		
		$this->middleware('student', ['only' => [
			'myApplic',
			'applyForm',
			'apply',
		]]);
		
		$this->middleware('competition_active', ['only' => [
			'applyForm',
			'apply',
		]]);
		
		//dodat za apply middleare koji gleda jel posoji natječaj
			
	}
	
	public function index() {
		
		$applics = Applic::where('status', 1)->orderBy('created_at', 'asc')->paginate(30);
		
		$applicsNum = count(Applic::where('status', '<>', 0)->get());
		
		$processedApplics = count(Applic::where('status', 2)->get());
		
		return view('applics', ['applics' => $applics, 'applicsNum' => $applicsNum, 'processedApplics' => $processedApplics]);
		
	}
	
	public function former(Request $request) {
		
		$competitions = Competition::where('status', 0)->orderBy('created_at', 'desc')->get();
		
		if(isset($request->competition)){
			
			$competition = Competition::find($request->competition);
			
		}
		else{
			
			$competition = Competition::where('status', 0)->orderBy('created_at', 'desc')->first();
			
		}
		
		if($competition){
			
			$applics = $competition->applics()->orderBy('created_at', 'asc')->paginate(30);
			
		}
		else {
			
			$applics = [];
			
		}
		
		return view('applics_former', ['applics' => $applics, 'competitions' => $competitions]);
		
	}
	
	public function myApplic(){
				
		$competition = Competition::orderBy('created_at', 'desc')->first();
				
		if(Utilities::competitionStatus() == 0){
			
			return view('myapplic', ['competition' => $competition]);
			
		}
		
		$user = Auth::user();
		$applic = $user->activeApplic();
		
		if(!$applic){
			
			if(Utilities::competitionStatus() == 2){
				
				//Session
				
				return "Natječaj je završio...Posljednja praksa2...";
			}
			
			return redirect('/apply');
			
		}
		else {
				
			$activities = $applic->activities;
			
			return view('myapplic', ['applic' => $applic, 'user' => $user, 'activities' => $activities]);
			
		}
				
	}
	
	
	public function applyForm($id = null){
		
		if(isset($id)){
		
			$user = User::find($id);	
			
		}
		else {
			
			$user = Auth::user();
			
		}
		
		$availableMonths = array();
		
		if(!empty(Competition::current()->availableMonths)){
			
			$availableMonths = explode(",", Competition::current()->availableMonths);
			
		}		
		
		if($applic = $user->activeApplic()){
			
			$activities = array(array('name' => '', 'checked' => '','year' => '','description' => ''));
			
			for($i=1; $i<=11; $i++){
				
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
			
			return view("forms.application", ['user' => $user, 'applic' => $applic, 'activities' => $activities, 'availableMonths' => $availableMonths]);
			
		}
		else {
			
			for($i=1; $i<=11; $i++){
				
				$activities[$i] = Utilities::activity($i);
				
			}
			
			
			return view("forms.application_empty", ['user' => $user, 'activities' => $activities, 'i' => 0, 'availableMonths' => $availableMonths]);
			
		}	
	
	}
	
	
	
	public function apply(Request $request){
		
		$user = Auth::user();
		
		$this->validate($request, [
			'academic_year' => 'required',
			'course' => 'required',
			'email' => 'required|max:100',
			'residence_town' => 'required|max:100',
			'residence_county' => 'required',
			'internship_town' => 'max:100',
			'desired_town' => 'max:100',
			'average_bacc_grade' => 'between:0,5'
		]);
		
		if($user->activeApplic()){
			
			$applic = $user->activeApplic();
			$newApplic = false;
			
		}
		else {
			
			$applic = new Applic;
			$newApplic = true;
			
		}
			
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
			
		if(!$user->activeApplic()){
			
			$applic->student()->associate($user);
			$applic->competition()->associate(Competition::current());
				
		}
		else {
				
			$applic->activities()->delete();
			
		}
		
		$applic->save();
		
		
		for($i=1; $i<=11; $i++){
			
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
		
		if($newApplic){
			
			Session::flash('status', 'Prijava je izrađena!');
			Session::flash('alert_type', 'alert-success');
					
		}
		else {
			
			Session::flash('status', 'Prijava je uređena!');
			Session::flash('alert_type', 'alert-warning');
					
		}
		
		return redirect("/myapplic");
		
	}
	
	public function view($id){
		
		$applic = Applic::find($id);
						
		$activities = $applic->activities;
			
		return view('applic', ['applic' => $applic, 'activities' => $activities]);
		
	}
	
	public function delete($id){
					
		Applic::find($id)->delete();		
			
		Session::flash('status', 'Prijava je obrisana!');
		Session::flash('alert_type', 'alert-danger');
		
		if(!Auth::user()->isAdmin()){
			
			return back();
			
		}
			
		return redirect('applics');
				
	}
		
}
