@extends('layouts.app')

@section('content')

	<div class="row">

		<div class="col-md-8">

			@if (session('success'))
				<div class="flash-message">
			    <div class="alert alert-success alert-dismissable fade in" style="margin-left: 50%;">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			    </button>{{ Session::get('success') }}</div></div>
			@endif	

			<h1 style="">Prakse</h1>

			<div class="table-responsive" style="margin-left: 25%; width: 100%;">

				<table class="table table-striped">

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
							<td>{{ $internship->company['name']}}</td>

						
						<td>
						{{ Form::open(['route' => ['internships.show', $internship->id], 'method' => 'GET']) }}
							<button class="btn btn-primary btn-sm">Prikaži</button>
						{{ Form::close() }}
						</td>
						
						
						<td><a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Uredi</a></td>
			
						<td>
						{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
							<button class="btn btn-danger btn-sm">Ukloni</button>
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
