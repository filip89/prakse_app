@extends('layouts.app')

<style>
.competition {
	width: 100%;
	margin-top: 15px;
}
.com_year {
	display: block;
	float: left;
}
.com_int {
	display: block;
	float: right;
}
.comp_btn {
	list-style-type: none;
	display: block;
	background-color: white;
	color: black;
	width: 170px;
	height: 30px;
	border: none;
}
.comp_btn:hover {
	background-color: #e7e7e7;
}
.comp_form {
	margin: 0;
	padding: 0;
}
.rejected {
	background-color: red;
}
.dropdown {
	float: right;
}
</style>

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

		<h1>Rezultati</h1>	
		
		@if(count($competitionList) > 0)	
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Izaberi natječaj</button>				 		
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuButton">
				@foreach($competitionList as $comp)
					<li>
						<form class="comp_form" action="{{ action('InternshipController@showResults') }}" method="GET">
							<input type="hidden" name="id" value="{{ $comp->id }}"> 
							<button class="comp_btn" type="submit">{{ $comp->name.'-'.$comp->year }}</button>
						</form>
					</li>
				@endforeach
				</ul>					
            </div>
		@endif
		
		@if($competitions->status != 0)
			<h3>Nema objavljenih rezultata</h3>
		@else
		<div class="btn btn-primary competition"><span class="com_year">Godina: {{ $competitions->year }}</span><span>{{ $competitions->name }}</span><span class="com_int">Dostupne prakse: {{ $competitions->internships_available }}</span></div>	
			{{--*/ $id = '' /*--}}
			{{--*/ $count = '' /*--}}
			<div class="res_box">																		
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
								<td>
									@if($internship->student_id == Auth::user()->id && $internship->confirmation_student === null && $internship->competition_id == $newCompetition->id)
										
										<form action="{{ action('InternshipController@reject') }}" method="POST">
											<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
											<input type="hidden" name="internship_id" value="{{ $internship->id }}">
											<input type="hidden" name="confirmation_student" value="0"> 
											<button type="submit" class="btn btn-danger btn-sm">Odbij</button>
										</form>								
									@elseif($internship->student_id == Auth::user()->id && $internship->confirmation_student !== null) 
										<i class="fa fa-close fa-2x" aria-hidden="true"></i>	
									@endif
								</td>
							</tr>
							{{--*/ $count += 1 /*--}}
						@endforeach	
						</tbody>							
					</table>
				</div>	
			</div>
		@endif
		</div>
	</div>
</div>

@endsection