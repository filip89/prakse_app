<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Internship;
use App\Company;
use App\User;
use App\Applic;
use App\InternMentor;
use App\CollegeMentor;
use App\Utilities;


class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        $this->middleware('auth');
    }

    public function index()
    {

        $internships = Internship::orderBy('total_points', 'desc')->get();
        $academicYear = new Utilities;

        return view('internships.index')
            ->with('internships', $internships)
            ->with('academicYear', $academicYear);     
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $academicYear = new Utilities;
        $course = new Utilities;
        $month = new Utilities;

        $applic = Applic::all();
        $companies= Company::pluck('name', 'id');
        $users = User::where('role', 'college_mentor')->pluck('last_name', 'id');

        return view('internships.create')
            ->with('applic', $applic)
            ->with('companies', $companies)
            ->with('collegeMentor', $users)
            ->with('academicYear', $academicYear)
            ->with('course', $course)
            ->with('month', $month);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $internship = new Internship;

        $internship->student_id = $request->student_id;
        $internship->company_id = $request->company_id;
        $internship->academic_year = $request->academic_year;
        $internship->average_bacc_grade = $request->average_bacc_grade;
        $internship->average_master_grade = $request->average_master_grade;
        $internship->activity_points = $request->activity_points;
        $internship->total_points = $request->total_points;
        $internship->start_date = $request->start_date;
        $internship->end_date = $request->end_date;
        $internship->duration = $request->duration;
        $internship->year = $request->year; 
        $internship->college_mentor_id = $request->college_mentor_id;
        $internship->student_comment = $request->student_comment;
        $internship->rating_by_student = $request->rating_by_student;
        $internship->intern_mentor_comment = $request->intern_mentor_comment;
        $internship->college_mentor_comment = $request->college_mentor_comment;
        $internship->confirmation_student = $request->confirmation_student;
        $internship->confirmation_admin = $request->confirmation_admin;
        $internship->save();

        return redirect()->route('internships.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $internship = Internship::with('college_mentor')->find($id);

        return view('internships.edit')->with('internship', $internship);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $internship = Internship::find($id);

        //validate
        $internship->company_id = $request->company_id;
        $internship->academic_year = $request->academic_year;
        $internship->average_bacc_grade = $request->average_bacc_grade;
        $internship->average_master_grade = $request->average_master_grade;
        $internship->activity_points = $request->activity_points;
        $internship->total_points = $request->total_points;
        $internship->start_date = $request->start_date;
        $internship->end_date = $request->end_date;
        $internship->duration = $request->duration;
        $internship->year = $request->year; 
        $internship->college_mentor_id = $request->college_mentor_id;
        $internship->student_comment = $request->student_comment;
        $internship->rating_by_student = $request->rating_by_student;
        $internship->intern_mentor_comment = $request->intern_mentor_comment;
        $internship->college_mentor_comment = $request->college_mentor_comment;
        $internship->confirmation_student = $request->confirmation_student;
        $internship->confirmation_admin = $request->confirmation_admin;
        $internship->save();

        Session::flash('success', 'Praksa uspješno uređena!');

        return redirect()->route('internships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $internship = Internship::find($id);

        $internship->delete();

        Session::flash('success', 'Praksa uspješno obrisana!');

        return redirect()->route('internships.index');
    }
}
