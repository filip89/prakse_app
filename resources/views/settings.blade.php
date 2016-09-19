@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
		
  <h1>Postavke</h1>
  			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#competition"><b>Natječaj</b></a></li>
			<li><a data-toggle="tab" href="#rest"><b>Ostalo</b></a></li>
		</ul>
		<div class="tab-content" style="padding:40px;">
			<div id="competition" class="tab-pane fade in active">
			@if(Utilities::competitionStatus() == 0)
				<h4 style="text-align:center;color:gray;margin-bottom:30px;">Nema otvorenog natječaja. Možete stvoriti novi.</h4>
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/competition/create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Naziv natječaja:</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('internships_available') ? ' has-error' : '' }}">
                            <label for="internships_available" class="col-md-4 control-label">Broj praksi:</label>

                            <div class="col-md-6">
                                <input id="internships_available" type="number" class="form-control" name="internships_available" value="{{ old('internships_available') }}">

                                @if ($errors->has('internships_available'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('internships_available') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-play" aria-hidden="true"></i> Otvori natječaj
                                </button>
                            </div>
                        </div>
                    </form>
			@elseif($competition->status == 1)
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/competition/close') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" style="margin:10px;">
									<i class="fa fa-btn fa-stop-circle settings_fa" aria-hidden="true"></i> Zatvori natječaj
                                </button>
								<button type="submit" class="btn btn-primary" style="margin:10px;" disabled>
                                    <i class="fa fa-btn fa-times settings_fa" aria-hidden="true"></i> Objavi i arhiviraj natječaj
                                </button>
                            </div>
                        </div>
                    </form>
			@elseif($competition->status == 2)		
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/competition/archive') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" style="margin:10px;" disabled>
									<i class="fa fa-btn fa-stop-circle settings_fa" aria-hidden="true"></i>Zatvori natječaj
								</button>
								<button type="submit" class="btn btn-primary" style="margin:10px;">
                                    <i class="fa fa-btn fa-times settings_fa" aria-hidden="true"></i> Objavi i arhiviraj natječaj
                                </button>
								
								
                            </div>
                        </div>
                    </form>
			@endif
			</div>
			<div id="rest" class="tab-pane fade">

			</div>
		</div>

            </div>
        </div>
    </div>
@endsection
