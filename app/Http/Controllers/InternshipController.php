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
            'showFormer',
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
            'showResults',
        ]]);
        
    }

    public function index() {
        $internship = Internship::where('status', 1)->orderBy('total_points', 'desc')->paginate(2);
        $academicYear = new Utilities;

        return view('internships.index')
            ->with('internships', $internship)
            ->with('academicYear', $academicYear);           
    }

    public function showFormer() {
        $internship = Internship::where('status', 0)->orderBy('total_points', 'desc')->paginate(2);
        $academicYear = new Utilities;

        return view('internships.former')
            ->with('internships', $internship)
            ->with('academicYear', $academicYear);             
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
            $internships = Internship::where('status', 0)->where('competition_id', $competitions->id)->orderBy('total_points', 'desc')->get();
        } else {
            $competitions = Competition::where('id', $request->id)->where('status', 0)->first();
            $internships = Internship::where('status', 0)->where('competition_id', $request->id)->orderBy('total_points', 'desc')->get();            
        }

        $newCompetition = Competition::orderBy('created_at', 'desc')->first();
        $competitionList = Competition::where('id', '!=', $competitions->id)->where('status', 0)->orderBy('created_at', 'desc')->get();
        $academicYear = new Utilities;

        return view('internships.results')
            ->with('internships', $internships)
            ->with('competitions', $competitions)
            ->with('academicYear', $academicYear)
            ->with('competitionList', $competitionList)
            ->with('newCompetition', $newCompetition);
    }
        
    

    public function create() {

        $academicYear = new Utilities;
        $course = new Utilities;
        $month = new Utilities;
        $activity = new Utilities;

        $applic = Applic::all();
        $companies= Company::all(); 
        $activities = Activity::all();     
        $collegeMentor = User::where('role', 'college_mentor')->get();
        $internMentor = User::where('role', 'intern_mentor')->get();

        return view('internships.create')
            ->with('applic', $applic)
            ->with('companies', $companies)
            ->with('collegeMentor', $collegeMentor)
            ->with('internMentor', $internMentor)
            ->with('academicYear', $academicYear)
            ->with('course', $course)
            ->with('month', $month)
            ->with('activities', $activities)
            ->with('activity', $activity);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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

    public function edit($id) {

        $internship = Internship::find($id);
        $companies= Company::where('status', 1)->get();
        $collegeMentor = User::where('role', 'college_mentor')->get();
        $internMentor = User::where('role', 'intern_mentor')->get();

        return view('internships.edit')
            ->with('internship', $internship)
            ->with('companies', $companies)
            ->with('collegeMentor', $collegeMentor)
            ->with('internMentor', $internMentor);       
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
        $internship->confirmation_student = $request->confirmation_student;
        $internship->confirmation_admin = $request->confirmation_admin;

        if($id != 0) {
            if($request->company_id != null) {
                $internship->status = 2;
            } else {
                $internship->status = 1;
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

        return redirect()->action('InternshipController@showFinal');
    }

    public function removeMentor(Request $request, $id) {

        $internship = Internship::find($id);

        $internship->college_mentor_id = null;
        $internship->save();

        Session::flash('status', 'Prestali ste mentorirati!');
        Session::flash('alert_type', 'alert-danger');

        return redirect()->action('InternshipController@showFinal');
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
        Session::flash('alert_type', 'alert-success');

        if($internship->status == 0) {
            return redirect()->action('InternshipController@showFormer');
        } elseif($internship->status == 2) {
           return redirect()->action('InternshipController@showFinal'); 
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

        $internships = Internship::all();

        return view('internships.report', ['internships' => $internships]);
    }

    public function getReport(Request $request) {

        $internships = Internship::where('student_id', $request->student_id)->get();
        $activities = $request->activities;
        $abstract = $request->abstract;

        $pdf = PDF::loadView('pdf.report', ['activities' => $activities, 'abstract' => $abstract, 'internships' => $internships]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Izvješće o obavljenoj praksi.pdf');
    }

}
