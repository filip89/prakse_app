<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Carbon\Carbon;
use App\Http\Requests;
use App\Internship;
use App\Company;
use App\User;
use App\Applic;
use App\InternMentor;
use App\CollegeMentor;
use App\Activity;
use App\Utilities;
use App\Competition;
use DB;
use PDF;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        $this->middleware('auth');

        $this->middleware('admin', ['only' => [
            'index',
            'edit',
            'change',
            'create',           
            'destroy',
            
        ]]);
        
        $this->middleware('mentor', ['only' => [
            'addMentor',
            'removeMentor',
            'showFinal',
            'getPDF',
        ]]);

        $this->middleware('student', ['only' => [
            'getReport',
            'createReport',
            
        ]]);
        
    }

    public function index() {
        $internship = Internship::where('status', 1)->orderBy('total_points', 'desc')->paginate(2);
        $companies= Company::where('status', 1)->get();
        $academicYear = new Utilities;

        return view('internships.index')
            ->with('internships', $internship)
            ->with('companies', $companies)
            ->with('academicYear', $academicYear);           
    }

    public function showFinal() {

        $internships = Internship::where('status', 2)->orderBy('total_points', 'desc')->paginate(2);
        $academicYear = new Utilities;

        return view('internships.final')
            ->with('internships', $internships)
            ->with('academicYear', $academicYear);
    }

    public function showResults(Request $request) {

        if($request->id == null) {
            $competitions = Competition::orderBy('created_at', 'desc')->where('status', 0)->first();
            if(count($competitions) != null) {
                $internships = Internship::where('status', 0)->where('competition_id', $competitions->id)->where('confirmation_admin', 1)->orderBy('total_points', 'desc')->get();
            } else {
                $internships = Internship::all();
            }
        } else {
            $competitions = Competition::where('id', $request->id)->where('status', 0)->first();
            $internships = Internship::where('status', 0)->where('competition_id', $request->id)->where('confirmation_admin', 1)->orderBy('total_points', 'desc')->get();            
        }

        $newCompetition = Competition::orderBy('created_at', 'desc')->first();
        if(count($competitions) != null) {
            $competitionList = Competition::where('id', '!=', $competitions->id)->where('status', 0)->orderBy('created_at', 'desc')->get();
        } else {
            $competitionList = null;
        }
        $academicYear = new Utilities;

        return view('internships.results')
            ->with('internships', $internships)
            ->with('competitions', $competitions)
            ->with('academicYear', $academicYear)
            ->with('competitionList', $competitionList)
            ->with('newCompetition', $newCompetition);
    }
    
    public function show($id) {

        $internships = Internship::where('id', $id)->get();

        return view('internships.show')
            ->with('internships', $internships);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    
    public function create(Request $request) {

        $applic = Applic::where('student_id', $request->student_id)->where('status', 1)->first();
        $companies= Company::all(); 
        $activities = Activity::where('applic_id', $applic->id)->get();     
        $collegeMentor = User::where('role', 'college_mentor')->get();
        $internMentor = User::where('role', 'intern_mentor')->get();

        return view('internships.create')
            ->with('app', $applic)
            ->with('companies', $companies)
            ->with('collegeMentor', $collegeMentor)
            ->with('internMentor', $internMentor)
            ->with('activities', $activities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {

        $internship = Internship::find($id);
        $applic = Applic::where('student_id', $internship->student_id)->where('status', '!=', 0)->first();
        $companies= Company::where('status', 1)->get();
        $collegeMentor = User::where('role', 'college_mentor')->get();
        $internMentor = User::where('role', 'intern_mentor')->get();
        $activities = Activity::all(); 

        return view('internships.edit')
            ->with('internship', $internship)
            ->with('companies', $companies)
            ->with('collegeMentor', $collegeMentor)
            ->with('internMentor', $internMentor)
            ->with('app', $applic)
            ->with('activities', $activities);       
    }

     public function change(Request $request, $id) {
        $this->validate($request, [       
            'average_bacc_grade' => 'required|numeric|between:2,5',
            'average_master_grade' => 'required|numeric|between:2,5',
            'activity_points' => 'required|integer|between:1,5',  
            'duration' => 'integer|between:1,90',
            'year' => 'integer|between:1990,9999', 
        ]);

        if($id != 0) {
            $internship = Internship::find($id);
        } else {
            $internship = new Internship;
            $applic = Applic::where('id', $request->applic_id)->first();
            $competitions = Competition::where('status', 2)->first();

            if(count($applic) != 0) {
                $applic->status = 2;
                $applic->save();  
            }  
            $internship->student_id = $request->student_id;
            $internship->competition_id = $competitions->id;   
        }
        
        $internship->company_id = $request->company_id ?: null;
        $internship->academic_year = $request->academic_year;
        $internship->average_bacc_grade = $request->average_bacc_grade;
        $internship->average_master_grade = $request->average_master_grade;
        $internship->activity_points = $request->activity_points;
        $internship->total_points = $request->average_bacc_grade + $request->average_master_grade + $request->activity_points;
        $internship->start_date = date('Y-m-d', strtotime($request->start_date)) ?: null;
        $internship->end_date = date('Y-m-d', strtotime($request->end_date)) ?: null;
        $internship->duration = $request->duration ?: null;
        $internship->year = $request->year ?: null;
        $internship->college_mentor_id = $request->college_mentor_id ?: null;
        $internship->intern_mentor_id = $request->intern_mentor_id ?: null;
        $internship->student_comment = $request->student_comment;
        $internship->rating_by_student = $request->rating_by_student ?: null;
        $internship->intern_mentor_comment = $request->intern_mentor_comment;
        $internship->college_mentor_comment = $request->college_mentor_comment;

        if($id != 0) {
            if($request->company_id != null && $internship->status != 0) {
                $internship->status = 2;
                $internship->confirmation_admin = 1;
            } elseif($request->company_id == null && $internship->status != 0) {
                $internship->status = 1;
                $internship->confirmation_admin = null;
            }           

            $internship->save();

            Session::flash('status', 'Praksa uspješno uređena!');
            Session::flash('alert_type', 'alert-warning');

            if($request->company_id == null) {
                return redirect()->route('internships.index');
            } else {
                return redirect()->action('InternshipController@showFinal');
            } 
            

        } else {

            $internship->save();

            Session::flash('status', 'Praksa uspješno stvorena!');
            Session::flash('alert_type', 'alert-success');

            return redirect()->route('internships.index');
        }   
    }

    public function reject(Request $request) {

        $internship = Internship::find($request->internship_id);

        $internship->confirmation_student = $request->confirmation_student;
        $internship->save();

        Session::flash('status', 'Odbili ste praksu!');
        Session::flash('alert_type', 'alert-danger');

        return redirect()->action('InternshipController@showResults');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function addMentor(Request $request, $id) {

        $internship = Internship::find($id);

        $internship->college_mentor_id = $request->college_mentor_id;
        $internship->save();

        Session::flash('status', 'Postali ste mentor!');
        Session::flash('alert_type', 'alert-success');

        if($internship->status != 0) {
            return redirect()->action('InternshipController@showFinal');
        } else {
            return redirect()->action('InternshipController@showResults');
        }
        
    }

    public function removeMentor(Request $request, $id) {

        $internship = Internship::find($id);

        $internship->college_mentor_id = null;
        $internship->save();

        Session::flash('status', 'Prestali ste mentorirati!');
        Session::flash('alert_type', 'alert-danger');

        if($internship->status != 0) {
            return redirect()->action('InternshipController@showFinal');
        } else {
            return redirect()->action('InternshipController@showResults');
        }
        
    }

    public function destroy($id) {
        $internship = Internship::find($id);
        $applic = Applic::where('student_id', $internship->student_id)->where('status', 2)->first();

        if(count($applic) != 0) {
            $applic->status = 1;
            $applic->save();  
        }
        
        $internship->delete();

        Session::flash('status', 'Praksa uspješno obrisana!');
        Session::flash('alert_type', 'alert-danger');

        if($internship->status == 1) {
            return redirect()->action('InternshipController@index');
        } elseif($internship->status == 2) {
           return redirect()->action('InternshipController@showFinal'); 
        } else {
           return redirect()->action('InternshipController@showResults'); 
        }
        
    }  
    public function getPDF(Request $request) {

        $internships = Internship::all();
        $collegeMentor = CollegeMentor::all();
        $date = Carbon::now()->toDateString();

        if($request->doc_id == 1) {

            $pdf = PDF::loadView('pdf.referral', ['internships' => $internships, 'collegeMentor' => $collegeMentor, 'date' => $date]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('Uputnica za studentsku praksu.pdf');

        } elseif($request->doc_id == 2) {

            $pdf = PDF::loadView('pdf.internship_ratification', ['internships' => $internships, 'collegeMentor' => $collegeMentor, 'date' => $date]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('Potvrda o obavljenoj praksi.pdf');
        } else {

            $pdf = PDF::loadView('pdf.education_ratification', ['internships' => $internships, 'collegeMentor' => $collegeMentor, 'date' => $date]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('Potvrda o obavljenoj edukaciji.pdf');
        }
          
    }

    public function createReport() {

        $internships = Internship::orderBy('created_at', 'desc')->where('status', 0)->where('student_id', Auth::user()->id)->first();

        return view('internships.report', ['internships' => $internships]);
    }

    public function getReport(Request $request) {

        $internships = Internship::orderBy('created_at', 'desc')->where('status', 0)->where('student_id', Auth::user()->id)->first();
        $activities = $request->activities;
        $abstract = $request->abstract;

        $pdf = PDF::loadView('pdf.report', ['activities' => $activities, 'abstract' => $abstract, 'internships' => $internships]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Izvješće o obavljenoj praksi.pdf');
    }

}
