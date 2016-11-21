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
			<li><a data-toggle="tab" href="#rest"><b>Admini</b></a></li>
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
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
							<label for="end_date" class="col-md-4 control-label">Prijave otvorene do:</label>

							<div class="col-md-6">
								<input type="text" class="form-control datepicker" name="end_date" required/>

								@if ($errors->has('end_date'))
									<span class="help-block">
										<strong>{{ $errors->first('end_date') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						{{Utilities::desiredMonth(12)}}
						<div class="months_checkboxes form-group{{ $errors->has('months') ? ' has-error' : '' }}">
							<label for="months" class="col-md-4 control-label">Dostupni mjeseci za praksu:</label>

							<div class="col-md-6">
								@for($i=1; $i<=12; $i++)
									<div style="display:block"><input class="cursor_pointer" type="checkbox" value="{{$i}}" name="month_{{$i}}"/><label style="display:inline;"> {{Utilities::desiredMonth($i)}}</label></div>
								@endfor
									<div style="display:block"><input class="cursor_pointer checkAll" type="checkbox"/><label class="checkAll_label" style="display:inline;"> Označi sve</label></div>
								@if ($errors->has('month_' . Utilities::desiredMonth($i)))
								<span class="help-block">
									<strong>{{ $errors->first('month_' . Utilities::desiredMonth($i)) }}</strong>
								</span>
								@endif
							</div>

						</div>
						
						<div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
							<label for="message" class="col-md-4 control-label">Poruka:</label>

							<div class="col-md-6">
								<textarea type="text" class="form-control" style="height:200px;max-height:700px;resize:vertical;" placeholder="Ovdje možete upisati opcionalnu porkuku koja će se prikazati uz objavu natječaja na naslonici." name="message"></textarea>

								@if ($errors->has('message'))
									<span class="help-block">
										<strong>{{ $errors->first('message') }}</strong>
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
				@else
				<div>Broj prijava: {{ $allApplicsNum }}</div>
				<div>Broj obrađenih prijava: {{ $processedApplicsNum }}</div>
				<div>Broj obrađenih praksi: {{ count($competition->internships()->where('status', 2)->get()) }}</div>
				@if($competition->status == 1)
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
				@endif
				@if($competition->status == 2)		
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/competition/archive') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
								<button style="display:block;margin:10px;" type="submit" class="btn btn-primary" disabled>
									<i class="fa fa-btn fa-stop-circle settings_fa" aria-hidden="true"></i>Zatvori natječaj
								</button>
								<button style="display:block;margin:10px;" type="submit" class="btn btn-primary" style="">
                                    <i class="fa fa-btn fa-times settings_fa" aria-hidden="true"></i> Objavi i arhiviraj natječaj
                                </button>
							</div>
							
							<div class="col-md-12 form-group{{ $errors->has('message') ? ' has-error' : '' }}">
								<label for="message" class="col-md-2 control-label">Poruka:</label>

								<div class="col-md-10">
									<textarea type="text" class="form-control" style="height:200px;max-height:700px;resize:vertical;" placeholder="Ovdje možete upisati opcionalnu poruku koja će se prikazati uz objavu rezultata na naslonici." name="message"></textarea>

								@if ($errors->has('message'))
									<span class="help-block">
										<strong>{{ $errors->first('message') }}</strong>
									</span>
								@endif
								</div>
							</div>
								
                           
                        </div>
                    </form>
				@endif

				<form class="form-horizontal" style="background-color:#f2f2f2;padding:20px;" role="form" method="POST" action="{{ url('/competition/edit/' . $competition->id) }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Naziv natječaja: </label>
                            <div class="col-md-6">
								<input class="form-control" name="name" type="text" maxlength="100" value="{{ $competition->name }}"></input>
								 @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
							</div>
						</div>
						
						<div class="action_buttons">
						<button type="submit" class="btn btn-primary" style="margin:10px;">
                            <i class="fa fa-btn fa-save settings_fa" aria-hidden="true"></i> Spremi
                        </button>					
						</div>
                </form>
			@endif
			</div>
			<div id="rest" class="tab-pane fade">
				<h2 style="display:table;margin:auto;margin-bottom:20px;">Popis admina</h2>
				<div class="table-responsive">
					<table class="table table-striped">
					<thead>
						<tr>
							<th>Ime i prezime</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($admins as $admin)	
						<tr>
							<td>
								{{ $admin->title . ' ' . $admin->name . ' ' . $admin->last_name }}
							</td>
							<td class="row_buttons">
								<a type="button" class="btn btn-info btn-sm" href="{{ url('/user/' . $admin->id) }}">Profil</a>
								<form action="{{ url('/user/admin/' . $admin->id) }}" method="POST">
								{{ csrf_field() }}
								<button type="button" data-info="{{ $admin->name . ' ' . $admin->last_name }}" class="btn btn-primary btn-sm delete" ><i class="fa fa-btn fa-times" aria-hidden="true"></i>Ukloni kao admina</button>
								</form>
							</td>
						</tr>
						@endforeach
					</thead>
					</table>
				</div>
			</div>
		</div>

            </div>
        </div>
    </div>
@endsection
@section('script')
	<script>
	$('.checkAll').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} 
		else {
			checkboxes.prop('checked', false);
		}
	});
	$('.months_checkboxes :checkbox').change(function() {
		if(!$(this).is(':checked')) {
			$('.checkAll').prop('checked', false);
		} 
	});
	</script>
@endsection
@section('modal_body_content')
	Ukinuti ulogu admina korisniku 
@endsection