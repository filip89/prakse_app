<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Applic;

use App\Internship;

use App\Competition;

use Session;

use DB;

class SettingController extends Controller
{
    //
	
	public function competition(){
		
		$competition = Competition::where('status', '<>', 0)->first();

			return view('settings', ['competition' => $competition]);
		
	}
	
}
