<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Company;

use App\Applic;

use Session;

class CompanyController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('auth');
		$this->middleware('mentor');
		
	}
	
	public function index(){
		
		$companies = Company::where('status', 1)->orderBy('created_at', 'desc')->paginate(1);

		return view('companies', ['companies' => $companies]);
		
	}
	
	public function former(){
		
		$companies = Company::where('status', 0)->orderBy('created_at', 'desc')->paginate(1);

		return view('companies_former', ['companies' => $companies]);
		
	}
	
	public function wishlist(){
		
		$applics = Applic::where('status', '<>', 0)->where('desired_company', '!=', "")->paginate(1);
		
		return view('companies_wishlist', ['applics' => $applics]);
		
	}
	
	public function profile($id){
		
		$company = Company::find($id);
		$internships = $company->internships()->where('status', '<>', 0)->where(function($query){ return $query->where('confirmation_student', "=", null)->orWhere('confirmation_student', "=", 1);})->get();
		
		return view('profiles.company', ['company' => $company, 'internships' => $internships]);
		
	}
	
	public function delete($id){
		
		$company = Company::find($id);
		$company->delete();
		
		Session::flash('status', 'Tvrtka je obrisana!');
		Session::flash('alert_type', 'alert-danger');
		
		return redirect('/company');
	}
	
	public function editForm($id){
		
		$company = Company::find($id);
		
		return view('forms.editCompany', ['company' => $company]);
		
	}
	
	public function edit(Request $request, $id){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'residence' => 'required|max:255',
			'email' => 'required|max:255|email',
			'phone' => 'required|max:50',
		]);
		
		$company = Company::find($id);
		
		$company->fill($request->all());
		$company->save();
		
		Session::flash('status', 'Tvrtka je uređena!');
		Session::flash('alert_type', 'alert-warning');
		
		return redirect('company/profile/' . $id);
		
	}
	
	public function createForm(){
			
		return view('forms.createCompany');
		
	}
	
	public function create(Request $request){
		
		$this->validate($request, [
            'name' => 'required|max:255',
			'residence' => 'required|max:255',
			'email' => 'required|max:255|email',
			'phone' => 'required|max:50',
		]);
		
		$company = new Company;
		
		$company->fill($request->all());
		$company->save();
		
		Session::flash('status', 'Tvrtka je dodana!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/company');
		
	}
	
	public function reinstate($id){
		
		$company = Company::find($id);
		
		$company->status = 1;
		$company->save();
		
		Session::flash('status', 'Tvrtka je dodana!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/company/former');
		
	}
	
}
