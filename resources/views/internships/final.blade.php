@extends('layouts.app')

@section('content')
<style>
td, th {
	text-align: center;
	vertical-align: middle !important;
}
</style>
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
			
				@if(count($internships) == null && !isset($_GET['srch_term']))
					<h3 style="text-align:center;color:gray;">Ne postoji niti jedna praksa.</h3>
				@else

				<div class="search_box">
					<form class="search_form" action="{{ action('InternshipController@showFinal') }}" method="GET">			
					    <div class="input-group">
					        {{ Form::text('srch_term', Request::get('srch_term'), ['class' => 'form-control', 'placeholder' => 'Pretraži...']) }}
						    <span class="input-group-btn">
						      	<button class="btn btn-default search-btn" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						    </span>
					    </div>			  	
					</form>
				</div>
				
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
								@if(count($internships) != null) <th></th> @endif					
							</tr>
						</thead>

						{{--*/ $count = '' /*--}}
					
						<tbody>	
						@if(count($internships) != null)
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
								{{ Form::open(['route' => ['internships.show', $internship->internships_id], 'method' => 'GET']) }}
									<button class="btn btn-info btn-sm">Prikaži</button>
								{{ Form::close() }}
																																
								@if(Auth::user()->role == 'college_mentor' && $internship->college_mentor_id == null)

								<form action="{{ action('InternshipController@addMentor', ['id' => $internship->internships_id]) }}" method="POST">
									<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
									<input type="hidden" name="college_mentor_id" value="{{ Auth::user()->id }}"> 
									<button type="submit" class="btn btn-success btn-sm">Mentoriraj</button>
								</form>
								
								@elseif($internship->college_mentor_id == Auth::user()->id)

								<form action="{{ action('InternshipController@removeMentor', ['id' => $internship->internships_id]) }}" method="POST">	
									<input name="_token" type="hidden" value="{!! csrf_token() !!}" />							
									<button type="button" class="btn btn-danger btn-sm delete">Otkaži mentorstvo</button>
								</form>
									
								@endif
							</td>
			
							</tr>
							{{--*/ $count += 1 /*--}}			
						@endforeach	
						@else
							<td colspan="10"><h3>Nema pronađenih rezultata</h3></td>
						@endif
						</tbody>												

					</table>

				</div>

				<div class="pagination">{{ $internships->render() }}</div>
				
				@endif
		</div>
	</div>
</div>	
@endsection

@section('modal_body_content')
	Otkazati mentorstvo
@endsection

