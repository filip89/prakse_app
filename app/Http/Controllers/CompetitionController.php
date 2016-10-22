<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Applic;

use App\Internship;

use App\Competition;

use Session;

use DB;

class CompetitionController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('admin');
		
	}
	
	public function store(Request $request){
		
		$this->validate($request, [
			'name' => 'required|max:100',
			'end_date' => 'required',
			'message' => 'max:10000',
		]);
		
		$checkedMonths = array();
		
		for($i=1; $i<=12; $i++){
			
			$month = 'month_' . $i;
			
			if(isset($request->$month)){
				
				$checkedMonths[] = $i;

			}	
			
		}
		
		
		
		$availableMonths = implode(',', $checkedMonths);
		
		
		$competition = new Competition;
		
		$competition->status = 1;
		$competition->year = date('Y');
		$competition->end_date = date('Y-m-d', strtotime($request->end_date));
		$competition->name = $request->name;
		$competition->message = $request->message;
		$competition->availableMonths = $availableMonths;
		
		$competition->save();
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je otvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
	public function archive(Request $request){
		
		$competition = Competition::where('status', 2)->first();
		
		$competition->status = 0;
		$competition->results_date = date('Y-m-d');
		$competition->message = $request->message;
		$competition->save();
		
		DB::table('applics')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('internships')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('companies')->where('status', '<>', 0)->update(array('status' => 0));
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je objavljen i arhiviran!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
	public function close(Request $request){
		
		$competition = Competition::where('status', 1)->first();
		
		$competition->status = 2;
		$competition->end_date = date('Y-m-d');
		$competition->save();
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je zatvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
	public function edit(Request $request, $id){
		
		$this->validate($request, [
			'name' => 'required|max:100',
		]);
		
		$competition = Competition::find($id);
		$competition->name = $request->name;
		$competition->save();
		
		Session::flash('status', 'Naziv natječaja je promijenjen u "' . $competition->name . '".');
		Session::flash('alert_type', 'alert-warning');
		
		return redirect('/settings');
		
	}
	
}
