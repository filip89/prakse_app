@extends('layouts.app')

@section('style')
	form {
		display: inline;
	}
	.table_section {
		text-decoration: underline;
		font-size: 16px;
		padding: 10px;
		background-color: #8080ff;
		color: white;
	}
	table:nth-of-type(1)  {
		margin-top: 20px;
	}
	.action_buttons {
		display: table;
		margin: auto;
	}
	.activity_info div:last-child{
		word-wrap: break-word;
	}
	
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
		@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
		@if($setting->status == 2)
		
		<h3 style="text-align:center;color:gray;">Natječaj je gotov. Vaša prijava se obrađuje.</h3>
		
		@elseif($setting->status == 1)
			<p>* Vaša prijava je zaprimljena i nalazi se u našoj bazi. Prijavu možete otkazati ili promijeniti podatke sve dok traje natječaj.</p>
			<div class="action_buttons">
				<a href="{{ url('/apply') }}"><button class="btn btn-warning">Uredi</button></a>
				<form action="{{ url('applic/'. Auth::user()->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
					<button type="button" class="btn btn-danger delete">Otkaži</button>
				</form>
			</div>
		@endif	
			<table class="table table-striped table-bordered">
				<tr><th colspan="2" class="table_section">Osobni podaci</th></tr>
				<tr><th>Ime:</th><td>{{ $user->name }}</td></tr>
				<tr><th>Prezime</th><td>{{ $user->last_name }}</td></tr>
				<tr><th>E-mail</th><td>{{ $applic->email }}</td></tr>
				<tr><th>Mjesto prebivališta:</th><td>{{ $applic->residence_town }}</td></tr>
				<tr><th>Županija prebivališta:</th><td>{{ $applic->residence_county }}</td></tr>
				<tr><th colspan="2" class="table_section">Akademski podaci</th></tr>
				<tr><th>Godina studija:</th><td>{{ Utilities::academicYear($applic->academic_year) }}</td></tr>
				<tr><th>Smjer:</th><td>{{ Utilities::course($applic->course) }}</td></tr>
				<tr><th>Prosjek na preddiplomskom:</th><td>{{ $applic->average_bacc_grade }}</td></tr>
				<tr><th>Prosjek na diplomskom:</th><td>{{ $applic->average_master_grade }}</td></tr>
				<tr><th colspan="2" class="table_section">Praksa</th></tr>
				<tr><th>Grad za odrađivanje prakse:</th><td>{{ $applic->internship_town }}</td></tr>
				<tr><th>Željene tvrtke:</th><td>{{ $applic->desired_company }}</td></tr>
				<tr><th>Željeni mjesec za odrađivanje prakse:</th><td>{{ Utilities::desiredMonth($applic->desired_month) }}</td></tr>
				<tr><th colspan="2" class="table_section">Aktivnosti</th></tr>
				<tr>
					<td colspan="2">
					@foreach($activities as $activity)
						<b><i class="fa fa-btn fa-check-square-o" aria-hidden="true"></i>{{ Utilities::activity($activity->number) }}</b><br/>
					@endforeach
					</td>
				</tr>
			</table>
        </div>
    </div>
</div>
@endsection