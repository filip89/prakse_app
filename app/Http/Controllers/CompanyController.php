<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Company;

use App\Applic;

use Session;

use App\Competition;

use App\Utilities;

use App\Internship;

use Illuminate\Pagination\LengthAwarePaginator;

class CompanyController extends Controller
{
    //
	
	public function __construct(){
		
		$this->middleware('auth');
		
	}
	
	public function index(Request $request){


	
		
		$allCompanies = Company::get();
		
		$confirmedCompanies = Company::where('status', 1)->get();
		
		if(isset($request->search)){
						
			$companies = Company::where('name', 'like', '%' . $request->search . '%')->paginate(1);
			
		}
		elseif($request->filter == 'all' || !isset($request->filter)){
			
			$companies = Company::orderBy('created_at', 'desc')->paginate(1);
			
		}
		elseif($request->filter == 'confirmed') {
			
			$companies = Company::where('status', 1)->orderBy('created_at', 'desc')->paginate(1);
			
		}
		elseif($request->filter == 'unconfirmed') {
			
			$companies = Company::where('status', 0)->orderBy('created_at', 'desc')->paginate(1);
		
		}
		
		return view('companies', ['allCompanies' => $allCompanies, 'companies' => $companies, 'confirmedCompanies' => $confirmedCompanies]);
		
	}
	
	public function wishlist(){
		
		$applics = Applic::where('status', '<>', 0)->where('desired_company', '!=', "")->paginate(1);
		
		return view('companies_wishlist', ['applics' => $applics]);
		
	}
	
	public function profile($id){
		
		$company = Company::find($id);
		
		$currentCompInterns = $company->internships()->where('status', '<>', 0)->where('confirmation_admin', "=", 1)->get();
		
		$recentInterns = $company->recentInternships();
		
		return view('profiles.company', ['company' => $company, 'currentCompInterns' => $currentCompInterns, 'recentInterns' => $recentInterns]);
		
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
			'spots' => 'required',
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
			'spots' => 'required',
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
		
		Session::flash('status', 'Tvrtka je dodana u natječaj!');
		Session::flash('alert_type', 'alert-success');
		
		return redirect('/company');
		
	}
	
	public function companyInternships($id){

		$company = Company::find($id);

		$internships = $company->internships()->where('status', 0)->where('confirmation_student', 1)->where('confirmation_admin', 1)->orderBy('created_at', 'desc')->paginate(1);
		
		return view('user_internships', ['internships' => $internships, 'user' => $company]);
		
	}
	
}
