<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Company;

class CompanyController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('auth');
		$this->middleware('admin');
		
	}
	
	public function index(){
		
		$companies = Company::orderBy('created_at', 'asc')->get();
		
		return view('companies', ['companies' => $companies]);
		
	}
	
	public function profile($id){
		
		$company = Company::find($id);
		
		return view('profiles.company', ['company' => $company]);
		
	}
	
	public function delete($id){
		
		$company = Company::find($id);
		$company->delete();
		
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
			'phone' => 'required|min:6|max:50',
		]);
		
		$company = Company::find($id);
		
		$company->fill($request->all());
		$company->save();
		
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
			'phone' => 'required|min:6|max:50',
		]);
		
		$company = new Company;
		
		$company->fill($request->all());
		$company->save();
		
		return redirect('company/profile/' . $company->id);
		
	}
	
	
}
