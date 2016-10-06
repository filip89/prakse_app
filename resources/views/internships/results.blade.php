@extends('layouts.app')

@section('style')
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
	width: 100px;
	padding-top: 10px;
}
.input-group-btn{
	position: relative;
}
@endsection

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

		@if(isset($competitions)) <h5><b>Datum objave:<br><span class="com_date">{{ date('d. m. Y', strtotime($competitions->results_date)) }}</span></b></h5> @endif
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

		<div class="search_box">
			<form class="search_form" action="{{ action('InternshipController@showResults') }}" method="GET">			
			    <div class="input-group">
			        {{ Form::text('srch_term', Request::get('srch_term'), ['class' => 'form-control', 'placeholder' => 'Pretraži...']) }}
			        @if(isset($_GET['id']))  {{ Form::hidden('id', $_GET['id']) }} @endif
				    <span class="input-group-btn">
				      	<button class="btn btn-default search-btn" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				    </span>
			    </div>			  	
			</form>
		</div>

		<div class="btn btn-primary competition"><span class="com_year">Godina: {{ $competitions->year }}</span><span>{{ $competitions->name }}</span></div>	
			{{--*/ $count = 0 /*--}}
			<div class="res_box">																		
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Rang</th>
								<th>Prosjek (preddiplomski)</th>
								<th>Prosjek (diplomski)</th>
								<th>Izvannastavne aktivnosti</th>
								<th>Ukupno</th>
								<th>Ime</th>
								<th>Prezime</th>
								<th>Akademska godina</th>
								<th>Tvrtka</th>	
								@if(!Auth::guest()) <th>Potvrda</th> 
								@endif					
							</tr>
						</thead>

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
								<td class="centered">
									@if($internship->student_id == Auth::user()->id && $internship->confirmation_student === 1 && $internship->competition_id == $newCompetition->id)																				
										<button type="button" data-toggle="modal" data-target="#myModalComment" class="btn btn-danger btn-sm">Odbij</button>									

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
															<input type="hidden" name="sid" value="{{ $internship->internships_id }}">
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

									@elseif($internship->confirmation_student == 0) 
										<div class="circle no"><i class="fa fa-times fa-xs x" aria-hidden="true"></i></div>	
									@elseif($internship->confirmation_student == 1)
										<div class="circle yes"><i class="fa fa-check fa-xs y" aria-hidden="true"></i></div>									
									@endif

									@if(Auth::user()->role == 'college_mentor' || Auth::user()->isAdmin())
									<td class="row_buttons centered">
										{{ Form::open(['route' => ['internships.show', $internship->internships_id], 'method' => 'GET']) }}
											<button class="btn btn-info btn-sm">Prikaži</button>
										{{ Form::close() }}
									
										@if($internship->college_mentor_id == null)

											<form action="{{ action('InternshipController@addMentor', ['id' => $internship->internships_id]) }}" method="POST">
												<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
												<input type="hidden" name="college_mentor_id" value="{{ Auth::user()->id }}"> 
												<button type="submit" class="btn btn-primary btn-sm">Mentoriraj</button>
											</form>
											
											@elseif($internship->college_mentor_id == Auth::user()->id)

											<form action="{{ action('InternshipController@removeMentor', ['id' => $internship->internships_id]) }}" method="POST">	
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
						@else
							<td colspan="10"><h3>Nema pronađenih rezultata</h3></td>
						@endif
						</tbody>							
					</table>
				</div>	
			</div>

			<div class="pagination">{{ $internships->render() }}</div>

		@endif
		</div>
	</div>
</div>
@endsection
