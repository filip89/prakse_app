@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-btn fa-cogs" aria-hidden="true"></i>{{ $setting->name . ' ' . $setting->year }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings/end') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                @if($setting->status != 1)
									<button type="submit" class="btn btn-primary" disabled>
								@else
									<button type="submit" class="btn btn-primary">
								@endif
                                    <i class="fa fa-btn fa-stop-circle settings_fa" aria-hidden="true"></i> Zatvori natječaj
                                </button>
                            </div>
                        </div>
                    </form>
					
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/settings/archive') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
								@if($setting->status != 2)
									<button type="submit" class="btn btn-primary" disabled>
								@else
									<button type="submit" class="btn btn-primary">
								@endif
                                    <i class="fa fa-btn fa-times settings_fa" aria-hidden="true"></i> Arhiviraj natječaj
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
