@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Prijava prakse</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/apply') }}">
                        {{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"><span class="req_field">* </span>Ime:</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" disabled/>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label"><span class="req_field">* </span>Prezime:</label>

                            <div class="col-md-8">
                                <input type="txt" class="form-control" name="last_name" value="{{ $user->last_name }}" disabled/>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><span class="req_field">* </span>E-mail adresa:</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $applic->email }}" required/>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_town') ? ' has-error' : '' }}">
                            <label for="residence_town" class="col-md-4 control-label"><span class="req_field">* </span>Mjesto prebivališta;</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="residence_town" value="{{ $applic->residence_town }}" required/>

                                @if ($errors->has('residence_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('residence_town') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_county') ? ' has-error' : '' }}">
                            <label for="residence_county" class="col-md-4 control-label"><span class="req_field">* </span>Županija prebivališta:</label>
							
                            <div class="col-md-8">
								
								<select class="form-control" name="residence_county" required>
                                @foreach(Utilities::county() as $i => $county)
									<option value="{{$i}}" @if($applic->residence_county == $i) {{ 'selected' }} @endif>{{ $county }}</option>
								@endforeach
								</select>

                                @if ($errors->has('residence_county'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('residence_county') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('academic_year') ? ' has-error' : '' }}">
                            <label for="academic_year" class="col-md-4 control-label"><span class="req_field">* </span>Godina studija:</label>
                            <div class="col-md-8">
								<select class="form-control" name="academic_year" value="{{ $applic->academic_year }}" required/>
									@if($applic->academic_year == 0)
										<option selected disabled hidden style='display: none'></option>
									@endif
									@if($applic->academic_year == 1)
										<option selected value="1">1. godina preddiplomskog</option>
									@else
										<option value="1">1. godina preddiplomskog</option>
									@endif
									@if($applic->academic_year == 2)
										<option selected value="2">2. godina preddiplomskog</option>
									@else
										<option value="2">2. godina preddiplomskog</option>
									@endif
									@if($applic->academic_year == 3)
										<option selected value="3">3. godina preddiplomskog</option>
									@else
										<option value="3">3. godina preddiplomskog</option>
									@endif
									@if($applic->academic_year == 4)
										<option selected value="4">1. godina diplomskog</option>
									@else
										<option value="4">2. godina diplomskog</option>
									@endif
									@if($applic->academic_year == 5)
										<option selected value="5">2. godina diplomskog</option>
									@else
										<option value="5">2. godina diplomskog</option>
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
                            <label class="col-md-4 control-label"><span class="req_field">* </span>Smjer:</label>

                            <div class="col-md-8">
								<select class="form-control" name="course" required/>
									@if($applic->course == null)
										<option selected disabled hidden style='display: none' value=''></option>
									@endif
									@if($applic->course == 1)
										<option selected value="1">Financijski menadžment</option>
									@else
										<option value="1">Financijski menadžment</option>
									@endif
									@if($applic->course == 2)
										<option selected value="2">Marketing</option>
									@else
										<option value="2">Marketing</option>
									@endif
									@if($applic->course == 3)
										<option selected value="3">Menadžemnt</option>
									@else
										<option value="3">Menadžemnt</option>
									@endif
									@if($applic->course == 4)
										<option selected value="4">Poduzetništvo</option>
									@else
										<option value="4">Poduzetništvo</option>
									@endif
									@if($applic->course == 5)
										<option selected value="5">Poslovna informatika</option>
									@else
										<option value="5">Poslovna informatika</option>
									@endif
								</select>

                                @if ($errors->has('course'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('average_bacc_grade') ? ' has-error' : '' }}">
                            <label for="average_bacc_grade" class="col-md-4 control-label">Prosjek na preddiplomskom:</label>

                            <div class="col-md-8">
                                <input type="number" max="5" step="0.01" min="0" class="form-control" name="average_bacc_grade" value="{{ $applic->average_bacc_grade }}" />

                                @if ($errors->has('average_bacc_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_bacc_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* ispunite ukoliko imate završenu barem jednu godinu preddiplomskog studija</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('average_master_grade') ? ' has-error' : '' }}">
                            <label for="average_master_grade" class="col-md-4 control-label">Prosjek na diplomskom</label>

                            <div class="col-md-8">
                                <input type="number" step="0.01" min="0" max="5" step="0.01" class="form-control" name="average_master_grade" value="{{ $applic->average_master_grade }}"/>

                                @if ($errors->has('average_master_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_master_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* ispunite ukoliko imate završenu barem jednu godinu diplomskog studija</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('internship_town') ? ' has-error' : '' }}">
                            <label for="internship_town" class="col-md-4 control-label">Grad za odrađivanje prakse:</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="internship_town" value="{{ $applic->internship_town }}" />

                                @if ($errors->has('internship_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('internship_town') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_company') ? ' has-error' : '' }}">
                            <label for="desired_company" class="col-md-4 control-label">Željena tvrtka:</label>

                            <div class="col-md-8">
                                <textarea type="text" class="form-control" name="desired_company" style="resize:vertical;max-height:200px" >{{ $applic->desired_company }}</textarea>

                                @if ($errors->has('desired_company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desired_company') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* navesti najviše 5 tvrtki</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_month') ? ' has-error' : '' }}">
                            <label for="desired_month" class="col-md-4 control-label">Željeni mjesec:</label>

                            <div class="col-md-8">
								<select class="form-control" name="desired_month" />
									@if($applic->desired_month == null)
										<option selected disabled hidden style='display: none' value=''></option>
									@endif
									@if($applic->desired_month == 6)
										<option selected value="6">Lipanj</option>
									@else
										<option value="6">Lipanj</option>
									@endif
									@if($applic->desired_month == 7)
										<option selected value="7">Srpanj</option>
									@else
										<option value="7">Srpanj</option>
									@endif
									@if($applic->desired_month == 8)
										<option selected value="8">Kolovoz</option>
									@else
										<option value="8">Kolovoz</option>
									@endif
									@if($applic->desired_month == 9)
										<option selected value="9">Rujan</option>
									@else
										<option value="9">Rujan</option>
									@endif
								</select>

                                @if ($errors->has('desired_month'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desired_month') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* odabarite mjesec kada biste najradije imali praksu</small></i></div>
                        </div>
						
						<h3 style="display:table;margin:auto;margin-bottom:20px;margin-top:30px;">Aktivnosti:</h3>
						
						<div class="form-group">                            

                            <div class="col-md-12">
							@for($i=1; $i<=10; $i++)
											<div class="col-sm-offset-2 col-sm-10" style="margin-bottom:10px;">
												<input class="cursor_pointer" type="checkbox" {{$activities[$i]['checked']}} name="activities[{{$i}}]"><label style="display:inline;"> {{$activities[$i]['name']}}</label>
											</div>
											<div class="activity_inputs" {{ $activities[$i]['checked'] ? '' : 'hidden'}}>
												<div class="form-group">
													<label class="col-md-2 col-sm-2 control-label" for="year_{{$i}}">Razdoblje: </label>
													<div class="col-md-10 col-sm-10">
														<input name="year_{{$i}}" type="text" class="form-control" value="{{$activities[$i]['year']}}">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 col-sm-2 control-label" for="description_{{$i}}">Opis: </label>
													<div class="col-md-10 col-sm-10">
														<textarea type="text" name="description_{{$i}}" maxlength="5000" style="resize:vertical;max-height:200px" class="form-control">{{$activities[$i]['description']}}</textarea>
													</div>
												</div>
											</div>		
							@endfor
							</div>
						</div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Spremi
                                </button>
                            </div>
                        </div>
						
                    </form>
                
            </div>
        </div>
    </div>
	</div>
</div>
@endsection
@section('script')
<script>
$(document).on("click", ".cursor_pointer", function(){
	$(this).parent().next().fadeToggle("slow");
});
</script>
@endsection

