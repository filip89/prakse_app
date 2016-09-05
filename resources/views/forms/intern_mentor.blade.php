@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Uredi profil</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/' . $user->id . '/editintern') }}">
                        {{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>

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
                                <input type="txt" class="form-control" name="last_name" value="{{ $user->last_name }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('job_description') ? ' has-error' : '' }}">
                            <label for="job_description" class="col-md-4 control-label">Radno mjesto</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="job_description" value="{{ $user->profile->job_description }}">

                                @if ($errors->has('job_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Telefon</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" value="{{ $user->profile->phone }}">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
			@if(Auth::user()->isAdmin())		
						<div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Tvrtka</label>

                            <div class="col-md-6">
                                <select class="form-control" name="company" required/>
										@if(!isset($user->profile->company))
											<option selected disabled hidden style='display: none' value=''></option>
											@foreach($companies as $company)
											<option value="{{$company->id}}">{{$company->name}}</option>
											@endforeach
										@else
											@foreach($companies as $company)
												@if($user->profile->company->id == $company->id)
												<option selected value="{{$company->id}}">{{$company->name}}</option>
												@else
												<option  value="{{$company->id}}">{{$company->name}}</option>
												@endif
											@endforeach
										@endif
								</select>

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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
