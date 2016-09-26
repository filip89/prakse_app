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
.com_date {
	display: block;
	padding-top: 10px;
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

		@if(isset($competitions)) <h5><b>Datum objave:<br><span class="com_date">{{ date('d M, Y', strtotime($competitions->results_date)) }}</span></b></h5> @endif
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
		
		@if((isset($competitions->status) && $competitions->status != 0) || $competitions == null)
			<h3>Nema objavljenih rezultata</h3> 
		@else
		<div class="btn btn-primary competition"><span class="com_year">Godina: {{ $competitions->year }}</span><span>{{ $competitions->name }}</span></div>	
			{{--*/ $count = 0 /*--}}
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
								@if(Auth::user()->role == 'college_mentor') <th>Potvrda</th> @else <th></th> 
								<th></th>
								@endif					
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
								<td style="text-align: center;">
									@if($internship->student_id == Auth::user()->id && $internship->confirmation_student === 1 && $internship->competition_id == $newCompetition->id)																				
										<button type="button" data-toggle="modal" data-target="#myModalComment" class="btn btn-danger btn-sm">Odbij</button>
										
									@elseif($internship->student_id == Auth::user()->id && $internship->confirmation_student !== null) 
										<i class="fa fa-times fa-2x" aria-hidden="true"></i>	
									@elseif(Auth::user()->role == 'college_mentor')
										@if($internship->confirmation_student === null)
											<i class="fa fa-spinner fa-2x" aria-hidden="true"></i>
										@elseif($internship->confirmation_student == 0)
											<i class="fa fa-times fa-2x test" aria-hidden="true"></i>
										@else
											<i class="fa fa-check fa-2x" aria-hidden="true"></i>
										@endif
									@endif

									@if(Auth::user()->role == 'college_mentor' || Auth::user()->isAdmin())
									<td class="row_buttons">
										{{ Form::open(['route' => ['internships.show', $internship->id], 'method' => 'GET']) }}
											<button class="btn btn-info btn-sm">Prikaži</button>
										{{ Form::close() }}
									
										@if($internship->college_mentor_id == null)

											<form action="{{ action('InternshipController@addMentor', ['id' => $internship->id]) }}" method="POST">
												<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
												<input type="hidden" name="college_mentor_id" value="{{ Auth::user()->id }}"> 
												<button type="submit" class="btn btn-success btn-sm">Mentoriraj</button>
											</form>
											
											@elseif($internship->college_mentor_id == Auth::user()->id)

											<form action="{{ action('InternshipController@removeMentor', ['id' => $internship->id]) }}" method="POST">	
												<input name="_token" type="hidden" value="{!! csrf_token() !!}" />							
												<button type="submit" class="btn btn-danger btn-sm">Otkaži mentorstvo</button>
											</form>
												
										@endif
									</td>	
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

@if($competitions != null)
<!-- Modal Create -->
<div class="modal fade" id="myModalComment" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Upišite razlog odbijanja prakse
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
               <form class="form-horizontal" role="form" method="POST" action="{{ action('InternshipController@rejectionComment') }}">
                    {{ csrf_field() }}
				
				
                <div class="form-group{{ $errors->has('rejection_comment') ? ' has-error' : '' }}">
					<input type="hidden" name="id" value="{{ $internship->id }}">
					<input type="hidden" name="confirmation_student" value="0">
                    <label for="rejection_comment" class="col-md-4 control-label">Komentar</label>
                    <div class="col-md-6">
                        <textarea rows="8" class="form-control" name="rejection_comment"></textarea>

                        @if ($errors->has('rejection_comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('rejection_comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                  
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary action_buttons">
                            <i class="fa fa-btn fa-sign-in"></i> Spremi
                        </button>
                    </div>
                </div>
                  
                </form>
                                                                                     
            </div>
            
        </div>
    </div>
</div>
@endif
@endsection
