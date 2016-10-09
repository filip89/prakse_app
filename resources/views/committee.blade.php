@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
			<h1>Članovi povjerenstva</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($members) == 0)
				<h3 style="text-align:center;color:gray;margin-bottom:30px;">Nema niti jedan član povjerenstva.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped" style="text-align:center;">
					@foreach ($members as $member)
					<tr>
						<td>{{ $member->title . " " . $member->name . " " . $member->last_name }}</td>
						@if (!Auth::guest() && Auth::user()->isAdmin())
						<td class="row_buttons">
							
							<form action="{{ url('committee/delete/'. $member->id) }}" method="POST">
								{{ csrf_field() }}
								<button type="button" data-info="{{ $member->name . ' ' . $member->last_name }}" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
							
						</td>
						@endif
					</tr>
					@endforeach	
				</table>
			</div>
			@endif
			@if(!Auth::guest() && Auth::user()->isAdmin())
			<button style="display:table;margin:auto" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Dodaj novog člana</button>
			@endif
		<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Dodaj novog člana</h4>
				</div>
				<div class="modal-body">
					 <form class="form-horizontal" role="form" method="POST" action="{{ url('/committee/create') }}">
                        {{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Prezime:</label>

                            <div class="col-md-6">
                                <input type="txt" class="form-control" name="last_name" value="{{old('last_name')}}" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Titula:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{old('title')}}"/>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Spremi
                                </button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Otkaži</button>
                            </div>
                        </div>
						
					</form>
				</div>
			</div>

		</div>
	</div>
        </div>
    </div>
</div>
@endsection

@section('modal_body_content')
	Ukloniti člana povjerenstva
@endsection
