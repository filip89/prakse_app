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

			<h1>Konačne prakse</h1>			
			
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
								<th>Potvrda</th>
								<th></th>					
							</tr>
						</thead>

						{{--*/ $count = '' /*--}}

						@foreach($internships as $internship)

						<tbody>	
						
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
							<td style="text-align: center;">
							@if($internship->confirmation_student == 1)
								<i class="fa fa-check fa-2x" aria-hidden="true"></i>
							@elseif($internship->confirmation_student === 0)
								<i class="fa fa-times fa-2x" aria-hidden="true"></i>
							@else
								<i class="fa fa-spinner fa-2x" aria-hidden="true"></i>
							@endif
							</td>

						
						<td class="row_buttons">
							{{ Form::open(['route' => ['internships.show', $internship->id], 'method' => 'GET']) }}
								<button class="btn btn-info btn-sm">Prikaži</button>
							{{ Form::close() }}
																															
							@if(Auth::user()->role == 'college_mentor' && $internship->college_mentor_id == null)

							<form action="{{ action('InternshipController@addMentor', ['id' => $internship->id]) }}" method="POST">
								<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
								<input type="hidden" name="college_mentor_id" value="{{ Auth::user()->id }}"> 
								<button type="submit" class="btn btn-success btn-sm">Mentoriraj</button>
							</form>
							
							@elseif($internship->college_mentor_id == Auth::user()->id)

							<form action="{{ action('InternshipController@removeMentor', ['id' => $internship->id]) }}" method="POST">	
								<input name="_token" type="hidden" value="{!! csrf_token() !!}" />							
								<button type="submit" class="btn btn-danger btn-sm">Otkaži</button>
							</form>
								
							@endif
						</td>
		
						</tr>
						{{--*/ $count += 1 /*--}}			

						</tbody>

						@endforeach	

					</table>

				</div>

				<div class="pagination">{{ $internships->render() }}</div>
				
				@endif
		</div>
	</div>
</div>	
@endsection

