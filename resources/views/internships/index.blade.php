@extends('layouts.app')

@section('content')

	<div class="row">

		<div class="col-md-12">

			@if (session('success'))
				<div class="flash-message">
			    <div class="alert alert-success alert-dismissable fade in">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			    </button>{{ Session::get('success') }}</div></div>
			@endif	

			<h1>Prakse</h1>
			<table class="table">
				<thead>
					<tr>
						<th>Rang</th>
						<th>Prosjek preddipl.</th>
						<th>Prosjek dipl.</th>
						<th>Izvannast. akt.</th>
						<th>Ukupno</th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>Akademska godina</th>
						<th>Mentor iz prakse</th>
						<th>Mentor nastavnik</th>
						<th>Tvrtka</th>						
					</tr>
				</thead>

				<tbody>	
				{{--*/ $count = '' /*--}}
				@foreach($internships as $internship)
					
					<tr>					
						<td>{{ $count+1 }}</td>
						<td>{{ $internship->average_bacc_grade }}</td>
						<td>{{ $internship->average_master_grade }}</td>
						<td>{{ $internship->activity_points }}</td>
						<td>{{ $internship->total_points }}</td>
						<td>{{ $internship->student['name']}}</td>
						<td>{{ $internship->student['last_name']}}</td>
						<td>{{ $academicYear->academicYear($internship->academic_year + 1) }}</td>
						<td>{{ $internship->intern_mentor['name']. ' '.$internship->intern_mentor['last_name']}}</td>
						<td>{{ $internship->college_mentor['name'].' '.$internship->college_mentor['last_name']}}</td>
						<td>{{ $internship->company['name']}}</td>

					

					<td><a href="{{ route('internships.edit', $internship->id) }}"><button class="btn btn-warning btn-xs">Uredi</button></a></td>

					<td>
					{{ Form::open(['route' => ['internships.show', $internship->id], 'method' => 'GET']) }}
						<button class="btn btn-primary btn-xs">Prikaži</button>
					{{ Form::close() }}
					</td>
					<td>
					{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
						<button class="btn btn-danger btn-xs">Ukloni</button>
					{{ Form::close() }}
					</td>
					
					</tr>
					{{--*/ $count += 1 /*--}}
				@endforeach

				</tbody>

			</table>

		</div>



	</div>

@endsection
