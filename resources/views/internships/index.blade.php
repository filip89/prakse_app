@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">

			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif	

			<h1>Prijavljene prakse</h1>

			@if(count($internships) < 1)
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna praksa.</h3>
			@else
			
			<div class="table-responsive">

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
							<th></th>					
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
							<td>{{ $academicYear->academicYear($internship->academic_year) }}</td>
							<td>{{ $internship->company['name']}}</td>

						
						<td class="row_buttons centered">
							{{ Form::open(['route' => ['internships.show', $internship->id], 'method' => 'GET']) }}
								<button class="btn btn-info btn-sm">Prikaži</button>
							{{ Form::close() }}
											
							{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
								<button type="button" class="btn btn-danger btn-sm delete">Ukloni</button>
							{{ Form::close() }}
						</td>
		
						</tr>
						{{--*/ $count += 1 /*--}}

					@endforeach

					</tbody>

				</table>
			</div>

			<div class="pagination">{{ $internships->render() }}</div>
			
			@endif
		</div>
	</div>
</div>	
@endsection



