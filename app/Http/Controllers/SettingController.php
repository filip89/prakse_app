<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Applic;

use App\User;

use App\Internship;

use App\Competition;

use Session;

use DB;

class SettingController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('admin');
		
	}
	
	public function open(){
		
		$allApplicsNum = count(Applic::where('status', '<>', 0)->get());
		
		$processedApplicsNum = count(Applic::where('status', 2)->get());
		
		$competition = Competition::where('status', '<>', 0)->first();
		
		$admins = User::where('admin', 1)->get();

		return view('settings', ['competition' => $competition, 'allApplicsNum' => $allApplicsNum, 'processedApplicsNum' => $processedApplicsNum, 'admins' => $admins]);
		
	}
	
}
