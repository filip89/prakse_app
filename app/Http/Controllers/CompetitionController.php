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
	
	public function store(Request $request){
		
		$competition = new Competition;
		
		$competition->status = 1;
		$competition->year = date('Y');
		$competition->name = $request->name;
		if(!empty($request->internships_available)){
			
			$competition->internships_available = $request->internships_available;		
		
		}	
		
		$competition->save();
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je otvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
	public function archive(Request $request){
		
		$competition = Competition::where('status', 2)->first();
		
		DB::table('applics')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('internships')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('companies')->where('status', '<>', 0)->update(array('status' => 0));
		
		$competition->status = 0;
		$competition->results_date = date('Y-m-d');
		$competition->save();
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je objavljen i arhiviran!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
		public function close(Request $request){
		
		$competition = Competition::where('status', 1)->first();
		
		$competition->status = 2;
		$competition->save();
		
		Session::flash('status', 'Natječaj "' . $competition->name . '" (' . $competition->year . '. godine) je zatvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
}
