<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CommitteeMember;

use Session;

class CommitteeController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('admin', ['only' => [
            'create',
            'delete',
        ]]);
		
	}
	
	public function index(){
		
		$members = CommitteeMember::orderBy('created_at', 'desc')->get();
		
		return view('committee', ['members' => $members]);
		
	}
	
	public function create(Request $request){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'title' => 'max:30',
			'last_name' => 'required|max:255',
		]);
		
		$member = new CommitteeMember();
		
		$member->title = $request->title;
		$member->name = $request->name;
		$member->last_name = $request->last_name;
		
		$member->save();
		
		Session::flash('status', 'Dodan je novi član povjerenstva!');
		Session::flash('alert_type', 'alert-success');		
		
		return back();
		
	}
	
	public function delete($id){
		
		CommitteeMember::find($id)->delete();
		
		Session::flash('status', 'Član povjerenstva je izbrisan!');
		Session::flash('alert_type', 'alert-danger');		
		
		return back();
		
	}
	
}
