@extends('layouts.app')

@section('content')
<style>
th {
    text-align: center;
    width: 50%;
}
.res_box {
    display: none;  
}
</style>
<div class="container">
    <div class="row">

        <div class="col-md-5">

        <h3>Podaci o studentu:</h3>

        @foreach($applic as $app)           
            <div class="table-responsive">
                <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Akademska godina</th>
                        <td  colspan="2">{{ Utilities::academicYear($app->academic_year) }}</td>
                    </tr>

                    <tr>
                        <th>Smjer</th></td>
                        <td  colspan="2">{{ Utilities::course($app->course) }}</td>
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
                        <td  colspan="2">{{ Utilities::desiredMonth($app->desired_month) }}</td>
                    </tr>

                    <tr>
                        <th>Mjesto prebivališta</th>
                        <td  colspan="2">{{ $app->residence_town }}</td>
                    </tr>

                    <tr>
                        <th>Županija prebivališta</th>
                        <td  colspan="2">{{ Utilities::county($app->residence_county) }}</td>
                    </tr>

                    <tr>
                        <th>Grad obavljanja prakse</th>
                        <td  colspan="2">{{ $app->internship_town }}</td>
                    </tr>

                    {{--*/ $count = 1 /*--}}
                    @if(count($activities) == 0)
                        <th>Izvannastavne aktivnosti</th>
                        <td>Nema aktivnosti</td>
                    @else                      
                        @foreach($activities as $act)
                            @if($act->applic_id == $app->id)
                            <tr>
                                @if($count == 1)
                                    <th>Izvannastavne aktivnosti</th>
                                @else
                                    <th></th>
                                @endif
                                <td colspan="2">{{ Utilities::activity($act->number) }}</td>
                                {{--*/ $count += 1 /*--}}  
                            </tr>                                   
                            @endif
                        @endforeach 
                        
                        <tr>
                                <th colspan="2"><div class="btn btn-primary competition">Bodovanje izvannastavnih aktivnosti</div></th>
                        </tr>
                        <tr>
                            <td style="background-color: white;" colspan="2">
                            <div class="res_box">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    
                                        <thead>
                                            <tr style="background-color: #e7e7e7;">
                                                <th>Broj izvannastavnih aktivnosti</th>
                                                <th>Broj dodijeljenih bodova temeljem izvannastavnih aktivnosti</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <th>1</th>
                                                <th>1</th>
                                            </tr>

                                            <tr>
                                                <th>2 - 3</th>
                                                <th>2</th>
                                            </tr>

                                            <tr>
                                                <th>4 - 5</th>
                                                <th>3</th>
                                            </tr>

                                            <tr>
                                                <th>6 - 7</th>
                                                <th>4</th>
                                            </tr>

                                            <tr>
                                                <th>8 - 10</th>
                                                <th>5</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </td>                           
                        </tr>
                        @endif          
                    </tbody>
                </table>
            </div>        
        @endforeach

        </div>

	    <div class="col-md-7">
	        <div class="panel panel-warning">
	            <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Uređivanje prakse</div>
	                <div class="panel-body"> 
						
                        <form class="form-horizontal" role="form" method="PUT" action="{{ action('InternshipController@change', $internship->id) }}">                   

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $internship->student['name'] }}" disabled>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Prezime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $internship->student['last_name'] }}" disabled>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('average_bacc_grade') ? ' has-error' : '' }}">
                            <label for="average_bacc_grade" class="col-md-4 control-label">Prosjek na preddiplomskom</label>

                            <div class="col-md-6">
                                <input type="number" max="5" step="0.01" min="2" class="form-control" name="average_bacc_grade" value="{{ old('average_bacc_grade', $internship->average_bacc_grade) }}" required/>

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
                                <input type="number" min="2" max="5" step="0.01" class="form-control" name="average_master_grade" value="{{ old('average_master_grade', $internship->average_master_grade) }}" required/>

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
                                <input type="number" step="1" min="0" max="5" class="form-control" name="activity_points" value="{{ old('activity_points', $internship->activity_points) }}" required/>

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
																		
									@if($internship->academic_year == 1)
										<option selected value="1">1. godina preddiplomskog</option>
									@else
										<option value="1">1. godina preddiplomskog</option>
									@endif
									@if($internship->academic_year == 2)
										<option selected value="2">2. godina preddiplomskog</option>
									@else
										<option value="2">2. godina preddiplomskog</option>
									@endif
									@if($internship->academic_year == 3)
										<option selected value="3">3. godina preddiplomskog</option>
									@else
										<option value="3">3. godina preddiplomskog</option>
									@endif
									@if($internship->academic_year == 4)
										<option selected value="4">1. godina diplomskog</option>
									@else
										<option value="4">2. godina diplomskog</option>
									@endif
									@if($internship->academic_year == 5)
										<option selected value="5">2. godina diplomskog</option>
									@else
										<option value="5">1. godina diplomskog</option>
									@endif
								</select>

                                @if ($errors->has('academic_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('academic_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Tvrtka</label>

                            <div class="col-md-6">
                                <select class="form-control" name="company_id"/>
                                    <option selected value=''></option>
                                    @foreach($companies as $elem)
                                        @if($elem->spotsAvailable() > 0)
                                            <option value="{{ $elem->id }}"
                                            @if($elem->id == $internship->company_id) {{ 'selected' }} @endif>
                                            {{ $elem->name }}</option>
                                        @endif
                                    @endforeach                                            
                                    
                                </select>

                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="col-md-4 control-label">Datum početka</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date', date('d M, Y', strtotime($internship->start_date))) }}"/>

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
                                <input type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date', date('d M, Y', strtotime($internship->end_date))) }}"/>

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
                                <input type="number" step="0.01" min="0" max="60" class="form-control" name="duration" value="{{ old('duration', $internship->duration) }}"/>

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
                                <input type="number" min="1990" max="2200" class="form-control" name="year" value="{{ old('year', $internship->year) }}"/>

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
									@foreach($collegeMentor as $elem)
                                        <option value=""></option>
										<option value="{{ $elem->id }}"
										@if($elem->id == $internship->college_mentor_id) {{ 'selected' }} @endif>
										{{ $elem->name.' '.$elem->last_name }}</option>
										
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
									@foreach($internMentor as $elem)

										<option value="{{ $elem->id }}"
										@if($elem->id == $internship->intern_mentor_id) {{ 'selected' }} @endif>
										{{ $elem->name.' '.$elem->last_name }}</option>

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
                                <input type="number" min="1" max="5" class="form-control" name="rating_by_student" value="{{ old('rating_by_student', $internship->rating_by_student) }}"/>

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
                                <textarea type="text" rows="4" class="form-control" name="student_comment" value="{{ old('student_comment', $internship->student_comment) }}">{{ $internship->student_comment }}</textarea>

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
                                <textarea rows="4" class="form-control" name="intern_mentor_comment" value="{{ old('intern_mentor_comment', $internship->intern_mentor_comment) }}">{{ $internship->intern_mentor_comment }}</textarea>

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
                                <textarea rows="4"  class="form-control" name="college_mentor_comment" value="{{ old('college_mentor_comment', $internship->college_mentor_comment) }}">{{ $internship->college_mentor_comment }}</textarea>

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
</div>  

@endsection