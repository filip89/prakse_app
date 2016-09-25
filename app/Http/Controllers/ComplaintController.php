<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests;

use App\Complaint;

use App\User;

use Session;

class ComplaintController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('admin',['except' => [
            'viewForm',
			'create'
		]]);
		
		$this->middleware('student',['only' => [
            'viewForm',
			'create'
		]]);
		
	}
	
	public function index(){
		
		$complaints = Complaint::orderBy('created_at', 'desc')->paginate(1);
		
		return view('complaints', ['complaints' => $complaints]);
		
	}
	
	public function view($id){
		
		$complaint = Complaint::find($id);
		$student = User::find($complaint->student_id);
		
		return view('complaint', ['complaint' => $complaint, 'student' => $student]);
		
	}
	
	public function viewForm(){
		
		return view("forms.complaint");
		
	}
	
	public function create(Request $request){
		
		$student = Auth::user();
		$complaint = new Complaint();
		
		$complaint->content = $request->content;
		$complaint->student()->associate($student);
		$complaint->save();
		
		Session::flash('status', 'Pritužba je poslana!');
		Session::flash('alert_type', 'alert-success');
		
		return back();
		
	}
	
	public function status($id){
		
		$complaint = Complaint::find($id);
		
		if($complaint->status == 0){
			
			$complaint->status = 1;
			
			Session::flash('status', 'Pritužba je označena kao riješena!');
			Session::flash('alert_type', 'alert-success');
			
		}
		else {
			
			$complaint->status = 0;
			
			Session::flash('status', 'Pritužba je označena kao neriješena!');
			Session::flash('alert_type', 'alert-warning');
			
		}
		
		$complaint->save();
		
		return back();
	}
	
	public function delete($id){
		
		Complaint::find($id)->delete();
		
		Session::flash('status', 'Pritužba je obrisana!');
		Session::flash('alert_type', 'alert-danger');
		
		return redirect('/complaints');
	}
	
}
