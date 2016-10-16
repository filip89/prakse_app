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
            'addCompany',
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

     public function index(Request $request) {
      
        $companies = Company::where('status', 1)->get();
        $academicYear = new Utilities;
        $identifier = 1;

        $internships = Internship::join('users', 'internships.student_id', '=', 'users.id')->select('*', 'internships.id as internships_id')->where(function($query) use ($request, $identifier) {

            return $this->searchTerm($request, $query, $identifier);

        })->where('status', 1)->orderBy('total_points', 'desc')->paginate(20);

        return view('internships.index')
            ->with('internships', $internships)
            ->with('companies', $companies)
            ->with('academicYear', $academicYear);           
    }

    public function showFinal(Request $request) {

        $academicYear = new Utilities;
        $identifier = 0;
        $internships = Internship::join('companies', 'internships.company_id', '=', 'companies.id')->join('users', 'internships.student_id', '=', 'users.id')->select('*', 'internships.id as internships_id')->where(function($query) use ($request, $identifier) {

            return $this->searchTerm($request, $query, $identifier);

        })->where('internships.status', 2)->orderBy('total_points', 'desc')->paginate(20);        
        

        return view('internships.final')
            ->with('internships', $internships)
            ->with('academicYear', $academicYear);
    }

    public function showResults(Request $request) {

        if($request->id == null) {
            $competitions = Competition::orderBy('created_at', 'desc')->where('status', 0)->first();
            $identifier = 0;
            if(count($competitions) != null) {
                
                $internships = Internship::join('companies', 'internships.company_id', '=', 'companies.id')->join('users', 'internships.student_id', '=', 'users.id')->select('*', 'internships.id as internships_id')->where(function($query) use ($request, $competitions, $identifier) {

                    return $this->searchTerm($request, $query, $identifier);

                })->where('internships.status', 0)->where('competition_id', $competitions->id)->where('confirmation_admin', 1)->orderBy('total_points', 'desc')->paginate(20);

            } else {

                $internships = null;
            }
           
        } else {
            $competitions = Competition::where('id', $request->id)->where('status', 0)->first();
            $identifier = 0;
            $internships = Internship::join('companies', 'internships.company_id', '=', 'companies.id')->join('users', 'internships.student_id', '=', 'users.id')->select('*', 'internships.id as internships_id')->where(function($query) use ($request, $competitions, $identifier) {
             
                return $this->searchTerm($request, $query, $identifier);

            })->where('internships.status', 0)->where('competition_id', $request->id)->where('confirmation_admin', 1)->orderBy('total_points', 'desc')->paginate(20);          
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
        $applic = $internship->applic;
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
            $internship->applic_id = $applic->id;
        }
        
        $internship->company_id = $request->company_id ?: null;
        $internship->academic_year = $request->academic_year;
        $internship->average_bacc_grade = $request->average_bacc_grade;
        $internship->average_master_grade = $request->average_master_grade;
        $internship->activity_points = $request->activity_points;
        $internship->total_points = $request->average_bacc_grade + $request->average_master_grade + $request->activity_points;

        if($request->start_date == '') {
            $internship->start_date = null;
        } else {
            $internship->start_date = date('Y-m-d', strtotime($request->start_date)); 
        }
        
        if($request->end_date == '') {
            $internship->end_date = null;
        } else {
            $internship->end_date = date('Y-m-d', strtotime($request->end_date)); 
        }
        
        $internship->duration = $request->duration ?: null;
        $internship->college_mentor_id = $request->college_mentor_id ?: null;
        $internship->intern_mentor_id = $request->intern_mentor_id ?: null;
        $internship->student_comment = $request->student_comment;
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

            if($request->company_id == null && $internship->status != 0) {
                return redirect()->route('internships.index');
            } elseif($request->company_id != null && $internship->status != 0) {
                return redirect()->action('InternshipController@showFinal');
            } elseif($internship->status == 0) {
                return redirect()->action('InternshipController@showResults'); 
            }

        } else {

            $internship->save();

            Session::flash('status', 'Praksa uspješno stvorena!');
            Session::flash('alert_type', 'alert-success');

            return redirect()->route('internships.index');
        }   
    }

    public function comment(Request $request) {
       
        $internship = Internship::find($request->id);

        if(Auth::user()->role == 'student') {
            if($internship->student_comment == null) {
                Session::flash('status', 'Komentar je uspješno dodan!');
                Session::flash('alert_type', 'alert-success');
            } else {
                Session::flash('status', 'Komentar je uspješno uređen!');
                Session::flash('alert_type', 'alert-warning');
            }
            $internship->student_comment = $request->student_comment;
        } elseif(Auth::user()->role == 'college_mentor') {
            if($internship->college_mentor_comment == null) {
                Session::flash('status', 'Komentar je uspješno dodan!');
                Session::flash('alert_type', 'alert-success');
            } else {
                Session::flash('status', 'Komentar je uspješno uređen!');
                Session::flash('alert_type', 'alert-warning');
            }
            $internship->college_mentor_comment = $request->college_mentor_comment;
        } else {
            if($internship->intern_mentor_comment == null) {
                Session::flash('status', 'Komentar je uspješno dodan!');
                Session::flash('alert_type', 'alert-success');
            } else {
                Session::flash('status', 'Komentar je uspješno uređen!');
                Session::flash('alert_type', 'alert-warning');
            }
            $internship->intern_mentor_comment = $request->intern_mentor_comment;
        }
        
        $internship->save();     

        return redirect()->action('InternshipController@show', $request->id);        
    }

    public function rejectionComment(Request $request) {

        $this->validate($request, [       
            'rejection_comment' => 'required',
        ]);

        $internship = Internship::where('student_id', Auth::user()->id)->where('status', 0)->orderBy('created_at', 'desc')->first();

        $internship->confirmation_student = $request->confirmation_student;
        $internship->rejection_comment = $request->rejection_comment;
   
        $internship->save();

        Session::flash('status', 'Odbili ste praksu!');
        Session::flash('alert_type', 'alert-danger');

        return redirect()->action('InternshipController@showResults');
        
    }
   
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

    public function addCompany(Request $request) {

        $internships = Internship::find($request->internship_id);

        $internships->company_id = $request->company_id;

        if($request->company_id == null) {
                return redirect()->route('internships.index');
        } else {
            $internships->confirmation_admin = 1;
            $internships->status = 2;
            $internships->save();

            Session::flash('status', 'Tvrtka uspješno dodana!');
            Session::flash('alert_type', 'alert-success');

            return redirect()->action('InternshipController@showFinal');
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

    public function starRating(Request $request) {

        $internships = Internship::where('student_id', $request->student_id)->where('status', 0)->orderBy('created_at', 'desc')->first();

        $internships->rating_by_student = $request->rating;
        $internships->save();

    }

    public function getStatistics() {

        $competitions = Competition::where('status', 0)->get();

        return view('internships.statistics_form', ['competitions' => $competitions]); 

    }

    public function statisticsReport(Request $request) {

        $date1 = date('Y-m-d', strtotime($request->date1));
        $date2 = date('Y-m-d', strtotime($request->date2));
        
        $internships = Internship::where('status', '!=', 1)->where('created_at', '>=', $date1)->where('created_at', '<=', $date2)->pluck('rating_by_student');
        $int_course = Internship::where('status', '!=', 1)->where('created_at', '>=', $date1)->where('created_at', '<=', $date2)->get();
        
        $e = 1;
        $course = [];
        $applic = [];
        foreach($int_course as $elem) {
            $course[$e] = $elem->applic['course'];
            $e += 1;
            //Get applic_id for activities array
            $applic[$elem->applic['id']] = $elem->applic['id'];
        }

        $rating = [];
        $max_rating = [];
        for($i=0; $i<count($internships); $i++) {
            $rating[$i+1] = $internships[$i];
        }

        $activities = Activity::all();
        $activity = [];
        $k = 0;
        foreach($activities as $act) {
            foreach($applic as $elem) {
                if($elem == $act->applic_id) {
                    $activity[$k] = $act->number;
                    $k++; 
                }
            } 
        }

        $rating = array_filter($rating, function($var){return !is_null($var);} );

        if(count($internships) != null) {
            if($rating != null) {
                $count = array_count_values($rating);
                $max_rating = array_keys($count, max($count));
            } else {
                $max_rating = null;
            }
            

            $count2 = array_count_values($course);
            $max_course = array_keys($count2, max($count2));

            if($activity != null) {
                $count3 = array_count_values($activity);
                $max_activity = array_keys($count3, max($count3));
            } else {
                $max_activity = null;
            }
            
        } else {
            $max_rating = null;
            $max_course = null;
            $max_activity = null;
        }
        
        $start_date = $request->date1;
        $end_date = $request->date2;      
        

        return view('pdf.statistics', ['internships' => $internships, 'activities' => $activities, 'start_date' => $start_date,  'end_date' => $end_date, 'max_rating' => $max_rating, 'course' => $course, 'max_course' => $max_course, 'activity' => $activity, 'applic' => $applic, 'max_activity' => $max_activity]);

    }

    public static function searchTerm($request, $query, $identifier) {

        if(($term = $request->get('srch_term'))) {
            $words = str_word_count($term);
            if($words > 1) {
                $term = str_word_count($term, 1, 'čćžšđ');
                $spacedTerm = str_word_count($request->get('srch_term'), 1, 'čćžšđ ');

                $query->whereIn('users.last_name', $term);
                $query->whereIn('users.name', $term);
                if($identifier == 0) {
                    $query->orWhereIn('companies.name', $spacedTerm);
                }
                
            } else {
                $term = str_replace(' ', '', $term);
                $query->orWhere('users.name', 'like', '%'. $term . '%');
                $query->orWhere('users.last_name', 'like', '%'. $term. '%');
                if($identifier == 0) {
                    $query->orWhere('companies.name', 'like', '%'. $term . '%');
                }
            }
                   
            }
    }

}
