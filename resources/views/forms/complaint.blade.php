@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
			@if(Session::has('status'))
				<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(Auth::user()->hasUnresolvedComplaint())
				<h3 style="margin-bottom:20px;" class="notice">*Trenutno imate neodgovorena pitanja u našoj bazi.</h3>
			@endif
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>{{ Auth::user()->name . ' ' . Auth::user()->last_name }} pritužba</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/complaint/create') }}">
                        {{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-2 control-label">E-mail: </label>

                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email" placeholder="e-mail na koji želite dobiti odgovor" required/>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-2 control-label">Pritužba: </label>

                            <div class="col-md-10">
                                <textarea type="text" class="form-control" style="resize:vertical;height:200px;max-height:500px" name="content" placeholder="Ovdje upišite pitanje od najviše 10000 znakova" required></textarea>

                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Pošalji
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
