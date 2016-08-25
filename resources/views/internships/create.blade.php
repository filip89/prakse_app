@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
		 <div class="col-md-4">
    	
		<h3>Podaci o studentu:</h3>                 

		@foreach($applic as $app)
			@if($app->student['id'] == $_GET['student_id'])

				<table class="table">
					<tr>
						<td>Akademska godina</td>
						<td>{{ $academicYear->academicYear($app->academic_year) }}</td>
					</tr>

					<tr>
						<td>Smjer</td>
						<td>{{ $course->course($app->course) }}</td>
					</tr>

					<tr>
						<td>E-mail</td>
						<td>{{ $app->email }}</td>
					</tr>

					<tr>
						<td>Prosjek ocjena (preddipl.)</td>
						<td>{{ $app->average_bacc_grade }}</td>
					</tr>

					<tr>
						<td>Prosjek ocjena (dipl.)</td>
						<td>{{ $app->average_master_grade }}</td>
					</tr>

					<tr>
						<td>Tvrtka</td>
						<td>{{ $app->desired_company }}</td>
					</tr>

					<tr>
						<td>Željeni mjesec obavljanja prakse</td>
						<td>{{ $month->desiredMonth($app->desired_month) }}</td>
					</tr>

					<tr>
						<td>Mjesto prebivališta</td>
						<td>{{ $app->residence_town }}</td>
					</tr>

					<tr>
						<td>Županija prebivališta</td>
						<td>{{ $app->residence_county }}</td>
					</tr>

					<tr>
						<td>Grad obavljanja prakse</td>
						<td>{{ $app->internship_town }}</td>
					</tr>

				</table>

			@endif
		@endforeach

		</div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Prijava prakse</div>
                <div class="panel-body">  

				
					{{ Form::open(array('route' => array('internships.store'), 'method' => 'POST')) }}
	
						{{ Form::hidden('student_id', $_GET['student_id']) }}

						{{ Form::label('name', 'Ime:') }}
						{{ Form::text('name', $_GET['name'], ['class' => 'form-control', 'disabled'] ) }}

						{{ Form::label('last_name', 'Prezime:') }}
						{{ Form::text('last_name', $_GET['last_name'], ['class' => 'form-control', 'disabled']) }}

						{{ Form::label('average_bacc_grade', 'Prosjek ocjena (preddiplomski):') }}
						{{ Form::number('average_bacc_grade', null, ['class' => 'form-control', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

						{{ Form::label('average_master_grade', 'Prosjek ocjena (diplomski):') }}
						{{ Form::number('average_master_grade', null, ['class' => 'form-control', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

						{{ Form::label('activity_points', 'Izvannastavne aktivnosti:') }}
						{{ Form::number('activity_points', null, ['class' => 'form-control', 'max' => 5, 'min' => 2, 'step' => 0.01]) }}

						{{ Form::label('total_points', 'Ukupno:') }}
						{{ Form::number('total_points', null, ['class' => 'form-control', 'step' => 0.01]) }}

						{{ Form::label('academic_year', 'Akademska godina:') }}
						{{ Form::select('academic_year', ['1. godina prediplomskog', '2. godina prediplomskog', '3. godina prediplomskog', '1. godina diplomskog', '2. godina diplomskog'], null, ['class' => 'form-control']) }}

						{{ Form::label('company_id', 'Tvrtka:') }}
						{{ Form::select('company_id', $companies, null, ['class' => 'form-control']) }}

						{{ Form::label('start_date', 'Datum početka:') }}
						{{ Form::date('start_date', null, ['class' => 'form-control']) }}

						{{ Form::label('end_date', 'Datum završetka:') }}
						{{ Form::date('end_date', null, ['class' => 'form-control']) }}

						{{ Form::label('duration', 'Trajanje:') }}
						{{ Form::text('duration', null, ['class' => 'form-control']) }}

						{{ Form::label('year', 'Godina:') }}
						{{ Form::number('year', null, ['class' => 'form-control']) }}

						{{ Form::label('college_mentor_id', 'Mentor - nastavnik:') }}
						{{ Form::select('college_mentor_id', $collegeMentor, null, ['class' => 'form-control']) }}

						{{ Form::label('rating_by_student', 'Ocjena studenta:') }}
						{{ Form::number('rating_by_student', null, ['max' => '5', 'min' => '1', 'class' => 'form-control']) }}

						{{ Form::label('student_comment', 'Komentar studenta:') }}
						{{ Form::text('student_comment', null, ['class' => 'form-control']) }}

						{{ Form::label('intern_mentor_comment', 'Komentar mentora:') }}
						{{ Form::text('intern_mentor_comment', null, ['class' => 'form-control']) }}

						{{ Form::label('college_mentor_comment', 'Komentar mentora iz prakse:') }}
						{{ Form::text('college_mentor_comment', null, ['class' => 'form-control']) }}

						{{ Form::submit('Create Application', ['class' => 'btn btn-primary']) }}

					{{ Form::close() }}
				
                </div>
            </div>
        </div>

    </div>  

</div>

@endsection
