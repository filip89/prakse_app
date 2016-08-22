@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Prijava prakse</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/applic/' . $user->id . '/edit') }}">
                        {{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"/>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Prezime</label>

                            <div class="col-md-6">
                                <input type="txt" class="form-control" name="last_name" value="{{ $user->last_name }}"/>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail adresa</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->applic->email }}"/>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_town') ? ' has-error' : '' }}">
                            <label for="residence_town" class="col-md-4 control-label">Mjesto prebivališta</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="residence_town" value="{{ $user->applic->residence_town }}"/>

                                @if ($errors->has('residence_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first(residence_town) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_county') ? ' has-error' : '' }}">
                            <label for="residence_county" class="col-md-4 control-label">Županija prebivališta</label>
							
                            <div class="col-md-6">
							
                                <input type="text" class="form-control" name="residence_county" value="{{ $user->applic->residence_county }}"/>

                                @if ($errors->has('residence_county'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first(residence_county) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('academic_year') ? ' has-error' : '' }}">
                            <label for="academic_year" class="col-md-4 control-label">Godina studija</label>
                            <div class="col-md-6">
								<select class="form-control" name="academic_year" value="{{ $user->applic->academic_year }}"/>
									@if($user->applic->academic_year == 0)
										<option selected disabled hidden style='display: none' value=''></option>
									@endif
									@if($user->applic->academic_year == 1)
										<option selected value="1">1. godina preddiplomskog</option>
									@else
										<option value="1">1. godina preddiplomskog</option>
									@endif
									@if($user->applic->academic_year == 2)
										<option selected value="2">2. godina preddiplomskog</option>
									@else
										<option value="2">2. godina preddiplomskog</option>
									@endif
									@if($user->applic->academic_year == 3)
										<option selected value="3">3. godina preddiplomskog</option>
									@else
										<option value="3">3. godina preddiplomskog</option>
									@endif
									@if($user->applic->academic_year == 4)
										<option selected value="4">1. godina diplomskog</option>
									@else
										<option value="4">1. godina diplomskog</option>
									@endif
									@if($user->applic->academic_year == 5)
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
                            <label class="col-md-4 control-label">Smjer</label>

                            <div class="col-md-6">
								<select class="form-control" name="course" />
									@if($user->applic->course == null)
										<option selected disabled hidden style='display: none' value=''></option>
									@endif
									@if($user->applic->course == 1)
										<option selected value="1">Financijski menadžment</option>
									@else
										<option value="1">Financijski menadžment</option>
									@endif
									@if($user->applic->course == 2)
										<option selected value="2">Marketing</option>
									@else
										<option value="2">Marketing</option>
									@endif
									@if($user->applic->course == 3)
										<option selected value="3">Menadžemnt</option>
									@else
										<option value="3">Menadžemnt</option>
									@endif
									@if($user->applic->course == 4)
										<option selected value="4">Poduzetništvo</option>
									@else
										<option value="4">Poduzetništvo</option>
									@endif
									@if($user->applic->course == 5)
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
                            <label for="average_bacc_grade" class="col-md-4 control-label">Prosjek na preddiplomskom</label>

                            <div class="col-md-6">
                                <input type="number" max="5" step="0.01" min="2" class="form-control" name="average_bacc_grade" value="{{ $user->applic->average_bacc_grade }}" />

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
                                <input type="number" max="5" step="0.01" class="form-control" name="average_master_grade" value="{{ $user->applic->average_master_grade }}"/>

                                @if ($errors->has('average_master_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_master_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('internship_town') ? ' has-error' : '' }}">
                            <label for="internship_town" class="col-md-4 control-label">Grad za odrađivanje prakse</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="internship_town" value="{{ $user->applic->internship_town }}" />

                                @if ($errors->has('internship_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('internship_town') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_company') ? ' has-error' : '' }}">
                            <label for="desired_company" class="col-md-4 control-label">Željena tvrtka (navesti maximalno 5)</label>

                            <div class="col-md-6">
                                <textarea type="text" class="form-control" name="desired_company" style="resize:vertical;max-height:200px" >{{ $user->applic->desired_company }}</textarea>

                                @if ($errors->has('desired_company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desired_company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_month') ? ' has-error' : '' }}">
                            <label for="desired_month" class="col-md-4 control-label">Željeni mjesec za odrađivanje prakse</label>

                            <div class="col-md-6">
								<select class="form-control" name="desired_month"/>
									@if($user->applic->desired_month == null)
										<option selected disabled hidden style='display: none' value=''></option>
									@endif
									@if($user->applic->desired_month == 6)
										<option selected value="6">Lipanj</option>
									@else
										<option value="6">Lipanj</option>
									@endif
									@if($user->applic->desired_month == 7)
										<option selected value="7">Srpanj</option>
									@else
										<option value="7">Srpanj</option>
									@endif
									@if($user->applic->desired_month == 8)
										<option selected value="8">Kolovoz</option>
									@else
										<option value="8">Kolovoz</option>
									@endif
									@if($user->applic->desired_month == 9)
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
                        </div>
						
						<div class="form-group">
                            <label class="col-md-4 control-label">Aktivnosti</label>
                            

                            <div class="col-md-6">
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[1]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label class="col-md-2 col-sm-2 control-label" for="year_0">Godina: </label>
											<div class="col-md-10 col-sm-10">
												<input type="text" name="year_0" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 col-sm-2 control-label" for="description_0">Opis: </label>
											<div class="col-md-10 col-sm-10">
												<textarea type="text" name="description_0" class="form-control"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[2]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_1">Godina: </label>
											<input type="text" name="year_1" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_1">Opis: </label>
											<textarea type="text" name="description_1" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[3]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_2">Godina: </label>
											<input type="text" name="year_2" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_2">Opis: </label>
											<textarea type="text" name="description_2" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[4]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_3">Godina: </label>
											<input type="text" name="year_3" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_2">Opis: </label>
											<textarea type="text" name="description_3" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[5]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_4">Godina: </label>
											<input type="text" name="year_4" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_4">Opis: </label>
											<textarea type="text" name="description_4" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[6]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_5">Godina: </label>
											<input type="text" name="year_5" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_5">Opis: </label>
											<textarea type="text" name="description_5" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[7]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_6">Godina: </label>
											<input type="text" name="year_6" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_6">Opis: </label>
											<textarea type="text" name="description_6" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[8]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_7">Godina: </label>
											<input type="text" name="year_7" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_7">Opis: </label>
											<textarea type="text" name="description_7" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[9]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_8">Godina: </label>
											<input type="text" name="year_8" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_8">Opis: </label>
											<textarea type="text" name="description_8" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="checkbox">
										<label><input type="checkbox" name="activities[10]">Option 1</label>
									</div>
									<div>
										<div class="form-group">
											<label for="year_9">Godina: </label>
											<input type="text" name="year_9" class="form-control">
										</div>
										<div class="form-group">
											<label for="description_9">Opis: </label>
											<textarea type="text" name="description_9" class="form-control"></textarea>
										</div>
									</div>
								</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Spremi
                                </button>
								<a href="/cancelapply">

										Povratak

								</a>
                            </div>
                        </div>
						
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection