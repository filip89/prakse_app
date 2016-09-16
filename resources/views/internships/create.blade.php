@extends('layouts.app')

@section('content')
<style>
td {
    text-align: center;
}
</style>
<div class="container">
    <div class="col-md-5">
	
		<h3>Podaci o studentu:</h3>                 

		@foreach($applic as $app)
			@if($app->id == $_GET['applic_id'])

				<div class="table-responsive">
                    <table class="table table-striped">
                    <tbody>
    					<tr>
    						<th>Akademska godina</th>
    						<td  colspan="2">{{ $academicYear->academicYear($app->academic_year) }}</td>
    					</tr>

    					<tr>
    						<th>Smjer</th></td>
    						<td  colspan="2">{{ $course->course($app->course) }}</td>
    					</tr>

    					<tr>
    						<th>E-mail</th></td>
    						<td  colspan="2">{{ $app->email }}</td>
    					</tr>

    					<tr>
    						<th>Prosjek ocjena (preddipl.)</th>   						
                            <td  colspan="2">{{ $app->average_bacc_grade }}</td>
    					</tr>

    					<tr>
    						<th>Prosjek ocjena (dipl.)</th>
    						<td  colspan="2">{{ $app->average_master_grade }}</td>
    					</tr>

    					<tr>
    						<th>Tvrtka</th>
    						<td  colspan="2">{{ $app->desired_company }}</td>
    					</tr>

    					<tr>
    						<th>Željeni mjesec obavljanja prakse</th>
    						<td  colspan="2">{{ $month->desiredMonth($app->desired_month) }}</td>
    					</tr>

    					<tr>
    						<th>Mjesto prebivališta</th>
    						<td  colspan="2">{{ $app->residence_town }}</td>
    					</tr>

    					<tr>
    						<th>Županija prebivališta</th>
    						<td  colspan="2">{{ $app->residence_county }}</td>
                            <td  colspan="2">{{ Utilities::county($app->residence_county) }}</td>
    					</tr>

    					<tr>
    						<th>Grad obavljanja prakse</th>
    						<td  colspan="2">{{ $app->internship_town }}</td>
    					</tr>

                        {{--*/ $count = 1 /*--}}

                        @foreach($activities as $act)
                            @if($act->applic_id == $app->id)
                            <tr>
                                @if($count == 1)
                                    <th>Izvannastavne aktivnosti</th>
                                @else
                                    <th></th>
                                @endif
                                <td colspan="2">{{ $activity->activity($act->number) }}</td>
                                {{--*/ $count += 1 /*--}}  
                            </tr>                                   
                            @endif
                        @endforeach 
                                                  
                        </tbody>
    				</table>
                </div>

			@endif
		@endforeach

		</div>

        <div class="col-md-7">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Prijava prakse</div>
                <div class="panel-body">  
			
					<form class="form-horizontal" role="form" method="POST" action="{{ action('InternshipController@change', 0) }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="student_id" value="{{ $_GET['student_id'] }}"> 

                        <input type="hidden" name="applic_id" value="{{ $_GET['applic_id'] }}"> 
                           

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $_GET['name'] }}" disabled>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Prezime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $_GET['last_name'] }}" disabled>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('average_bacc_grade') ? ' has-error' : '' }}">
                            <label for="average_bacc_grade" class="col-md-4 control-label">Prosjek na preddiplomskom</label>

                            <div class="col-md-6">
                                <input type="number" max="5" step="0.01" min="2" class="form-control" name="average_bacc_grade" required/>

                                @if ($errors->has('average_bacc_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_bacc_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('average_master_grade') ? ' has-error' : '' }}">
                            <label for="average_master_grade" class="col-md-4 control-label">Prosjek na diplomskom</label>

                            <div class="col-md-6">
                                <input type="number" min="2" max="5" step="0.01" class="form-control" name="average_master_grade" required/>

                                @if ($errors->has('average_master_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_master_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('activity_points') ? ' has-error' : '' }}">
                            <label for="activity_points" class="col-md-4 control-label">Izvannastavne aktivnosti</label>

                            <div class="col-md-6">
                                <input type="number" step="1" min="0" max="5" class="form-control" name="activity_points" required/>

                                @if ($errors->has('activity_points'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('activity_points') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group">
                            <label class="col-md-4 control-label">Godina studija</label>

                            <div class="col-md-6">
								<select class="form-control" name="academic_year" required/>
																		
										<option value="1">1. godina preddiplomskog</option>
																	
										<option value="2">2. godina preddiplomskog</option>
									
										<option value="3">3. godina preddiplomskog</option>
									
										<option value="4">1. godina diplomskog</option>
									
										<option value="5">2. godina diplomskog</option>
									
								</select>

                                @if ($errors->has('academic_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('academic_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                     
                                                            					
						<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="col-md-4 control-label">Datum početka</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="start_date"/>

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <label for="end_date" class="col-md-4 control-label">Datum završetka</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="end_date"/>

                                @if ($errors->has('end_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                            <label for="duration" class="col-md-4 control-label">Trajanje</label>

                            <div class="col-md-6">
                                <input type="number" step="1" min="1" max="90" class="form-control" name="duration"/>

                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="year" class="col-md-4 control-label">Godina</label>

                            <div class="col-md-6">
                                <input type="number" min="1990" max="9999" class="form-control" name="year"/>

                                @if ($errors->has('year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						

						@if(count($collegeMentor) != 0)

						<div class="form-group">
                            <label for="college_mentor_id" class="col-md-4 control-label">Mentor nastavnik</label>

                            <div class="col-md-6">
                                <select class="form-control" name="college_mentor_id"/>
                                	<option selected disabled hidden style='display: none' value=''></option>
									@foreach($collegeMentor as $elem)
										<option value="{{ $elem->id }}">{{ $elem->name.' '.$elem->last_name }}</option>
										
									@endforeach
                                </select>
                             

                                @if ($errors->has('college_mentor_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college_mentor_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						@endif

						@if(count($internMentor) != 0)

						<div class="form-group">
                            <label for="intern_mentor_id" class="col-md-4 control-label">Mentor iz prakse</label>

                            <div class="col-md-6">
                                <select class="form-control" name="intern_mentor_id"/>
                                	<option selected disabled hidden style='display: none' value=''></option>
									@foreach($internMentor as $elem)
										<option value="{{ $elem->id }}">{{ $elem->name.' '.$elem->last_name }}</option>
									@endforeach
                                </select>

                                @if ($errors->has('intern_mentor_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('intern_mentor_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						@endif


						<div class="form-group{{ $errors->has('rating_by_student') ? ' has-error' : '' }}">
                            <label for="rating_by_student" class="col-md-4 control-label">Studentova ocjena prakse</label>

                            <div class="col-md-6">
                                <input type="number" min="1" max="5" class="form-control" name="rating_by_student" value=null/>

                                @if ($errors->has('rating_by_student'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rating_by_student') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('student_comment') ? ' has-error' : '' }}">
                            <label for="student_comment" class="col-md-4 control-label">Komentar studenta</label>

                            <div class="col-md-6">
                                <textarea rows="4" class="form-control" name="student_comment"></textarea>

                                @if ($errors->has('student_comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('intern_mentor_comment') ? ' has-error' : '' }}">
                            <label for="intern_mentor_comment" class="col-md-4 control-label">Komentar mentora iz prakse</label>

                            <div class="col-md-6">
                                <textarea rows="4"  class="form-control" name="intern_mentor_comment"></textarea>

                                @if ($errors->has('intern_mentor_comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('intern_mentor_comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('college_mentor_comment') ? ' has-error' : '' }}">
                            <label for="college_mentor_comment" class="col-md-4 control-label">Komentar mentora nastavnika</label>

                            <div class="col-md-6">
                                <textarea rows="4"  class="form-control" name="college_mentor_comment"></textarea>

                                @if ($errors->has('college_mentor_comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('college_mentor_comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
				
						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Spremi
                                </button>
								<a type="button" class="btn btn-default" href="{{ URL::previous() }}">Povratak</a>
                            </div>
                        </div>

					</form>
					
                </div>
            </div>
        </div>

    </div>  

</div>

@endsection

