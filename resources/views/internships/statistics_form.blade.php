@extends('layouts.app')

@section('content')
	<div class="col-md-4 col-md-offset-4">
	@if(isset($competitions) && count($competitions) == null || !isset($competitions))
		<h1>Statistika</h1>
		<h3>Nema dovoljno podataka za izradu izvještaja</h3>
	@else	
		<div class="panel panel-success">
			<div class="panel-heading"><i class="fa fa-btn fa-bar-chart" aria-hidden="true"></i>Statistika</div>
				<div class="panel-body">

					<h4 class="centered" style="padding-bottom: 20px;">Upišite razdoblje za koje želite generirati statistički izvještaj</h4>

					<form class="form-horizontal" role="form" method="POST" action="{{ action('InternshipController@statisticsReport') }}"> 
					{{ csrf_field() }}

						<div class="form-group{{ $errors->has('date1') ? ' has-error' : '' }}">
		                    <label for="date1" class="col-md-4 control-label">Datum početka</label>

		                    <div class="col-md-6">
		                    	<input type="text" class="form-control datepicker" name="date1" required>
		                        
		                        @if ($errors->has('date1'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('date1') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

		                <div class="form-group{{ $errors->has('date2') ? ' has-error' : '' }}">
		                    <label for="date2" class="col-md-4 control-label">Datum početka</label>

		                    <div class="col-md-6">
		                    	<input type="text" class="form-control datepicker" name="date2" required>
		                        
		                        @if ($errors->has('date2'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('date2') }}</strong>
		                            </span>
		                        @endif
		                    </div>
		                </div>

						<div class="form-group">
			                <div class="col-md-6 col-md-offset-4">
			                    <button type="submit" class="btn btn-success">Generiraj</button>							
			                </div>
			            </div>

					</form>

				</div>
			</div>
		</div>	
	</div>
	@endif
@endsection