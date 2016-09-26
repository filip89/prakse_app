<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Competition;
use App\Utilities;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		if(Utilities::competitionStatus() != 0){
			$competition = Competition::current();
		}
		else{
			$competition = Competition::previous();
		}
		
        return view('home', ['competition' => $competition]);
		//return "Hello " . Auth::user()->name;
    }
}
