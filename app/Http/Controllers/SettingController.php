<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Applic;

use App\Internship;

use App\Setting;

use Session;

use DB;

class SettingController extends Controller
{
    //
	
	public function form(){
		
		$setting = Setting::where('status', '<>', 0)->first();
		
		if($setting){
			
			return view('settings.edit', ['setting' => $setting]);
			
		}
		
		return view('settings.create');
		
	}
	
	public function store(Request $request){
		
		$setting = new Setting;
		
		$setting->status = 1;
		$setting->year = date('Y');
		$setting->name = $request->name;
		$setting->internships_available = $request->internships_available;		
		
		$setting->save();
		
		Session::flash('status', 'Natječaj "' . $setting->name . '" (' . $setting->year . '. godine) je otvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
	public function archiveCompetition(Request $request){
		
		$setting = Setting::where('status', 2)->first();
		
		DB::table('applics')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('internships')->where('status', '<>', 0)->update(array('status' => 0));
		DB::table('companies')->where('status', '<>', 0)->update(array('status' => 0));
		
		$setting->status = 0;
		$setting->save();
		
		Session::flash('status', 'Natječaj "' . $setting->name . '" (' . $setting->year . '. godine) je zatvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
		public function endCompetition(Request $request){
		
		$setting = Setting::where('status', 1)->first();
		
		$setting->status = 2;
		$setting->save();
		
		Session::flash('status', 'Natječaj "' . $setting->name . '" (' . $setting->year . '. godine) je zatvoren!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/settings');
		
	}
	
}
