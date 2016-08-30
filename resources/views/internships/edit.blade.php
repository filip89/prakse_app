@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
	    <div class="col-md-8 col-md-offset-2">
	        <div class="panel panel-default">
	            <div class="panel-heading">Prijava prakse</div>
	                <div class="panel-body"> 
						{{ Form::model($internship, array('route' => array('internships.update', $internship->id), 'method' => 'PUT')) }}

							{{ Form::label('name', 'Ime:') }}
							{{ Form::text('name', $internship->student['name'], ['class' => 'form-control', 'disabled'] ) }}

							{{ Form::label('last_name', 'Prezime:') }}
							{{ Form::text('last_name', $internship->student['last_name'], ['class' => 'form-control', 'disabled']) }}

							{{ Form::label('average_bacc_grade', 'Prosjek ocjena (preddiplomski):') }}
							{{ Form::number('average_bacc_grade', null, ['class' => 'form-control', 'required', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

							@if ($errors->has('average_bacc_grade'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('average_bacc_grade') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('average_master_grade', 'Prosjek ocjena (diplomski):') }}
							{{ Form::number('average_master_grade', null, ['class' => 'form-control', 'required', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

							@if ($errors->has('average_master_grade'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('average_master_grade') }}</strong>
	                            </span>
	                  		@endif

							{{ Form::label('activity_points', 'Izvannastavne aktivnosti:') }}
							{{ Form::number('activity_points', null, ['class' => 'form-control', 'required', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

							@if ($errors->has('activity_points'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('activity_points') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('total_points', 'Ukupno:') }}
							{{ Form::number('total_points', null, ['class' => 'form-control', 'required', 'step' => 0.01]) }}

							@if ($errors->has('total_points'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('total_points') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('academic_year', 'Akademska godina:') }}
							{{ Form::select('academic_year', ['1. godina prediplomskog', '2. godina prediplomskog', '3. godina prediplomskog', '1. godina diplomskog', '2. godina diplomskog'], null, ['class' => 'form-control']) }}

							@if(count($companies) != 0)
							{{ Form::label('company_id', 'Tvrtka:') }}
							{{ Form::select('company_id', $companies, null, ['class' => 'form-control']) }}
							@endif

							{{ Form::label('start_date', 'Datum početka:') }}
							{{ Form::text('start_date', date('d M, Y', strtotime($internship->start_date)), ['class' => 'form-control datepicker', 'required']) }}

							@if ($errors->has('start_date'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('start_date') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('end_date', 'Datum završetka:') }}
							{{ Form::text('end_date', date('d M, Y', strtotime($internship->end_date)), ['class' => 'form-control datepicker', 'required']) }}

							@if ($errors->has('end_date'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('end_date') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('duration', 'Trajanje:') }}
							{{ Form::text('duration', null, ['class' => 'form-control', 'required']) }}

							@if ($errors->has('duration'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('duration') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('year', 'Godina:') }}
							{{ Form::number('year', null, ['class' => 'form-control', 'required']) }}
							
							@if ($errors->has('year'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('year') }}</strong>
	                            </span>
	                        @endif

							{{ Form::label('college_mentor_id', 'Mentor - nastavnik:') }}
							{{ Form::select('college_mentor_id', ['' => 'Nema mentora'] + $collegeMentor, null, ['class' => 'form-control']) }}

							{{ Form::label('intern_mentor_id', 'Mentor iz prakse:') }}
							{{ Form::select('intern_mentor_id', ['' => 'Nema mentora'] + $internMentor, null, ['class' => 'form-control']) }}

							{{ Form::label('rating_by_student', 'Ocjena studenta:') }}
							{{ Form::number('rating_by_student', null, ['max' => '5', 'min' => '1', 'class' => 'form-control']) }}

							{{ Form::label('student_comment', 'Komentar studenta:') }}
							{{ Form::text('student_comment', null, ['class' => 'form-control']) }}

							{{ Form::label('intern_mentor_comment', 'Komentar mentora:') }}
							{{ Form::text('intern_mentor_comment', null, ['class' => 'form-control']) }}

							{{ Form::label('college_mentor_comment', 'Komentar mentora iz prakse:') }}
							{{ Form::text('college_mentor_comment', null, ['class' => 'form-control']) }}

							{{ Form::submit('Spremi', ['class' => 'btn btn-primary']) }}

						{{ Form::close() }}
	   				</div>
	   			</div>
	    	</div>
	    </div>
    </div>
</div>  

@endsection