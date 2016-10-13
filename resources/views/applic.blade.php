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
			<h1 style="display:table;margin:auto">Prijava</h1>
			<a  class="link_object" style="display:table;margin:auto;margin-bottom:30px;font-size:16px" href="{{ url('/user/' . $applic->student_id) }}">{{ $applic->student->name . ' ' . $applic->student->last_name }}</a>
			<div class="action_buttons" style="margin-bottom:20px">
				@if(Utilities::competitionStatus() == 2 && $applic->status == 1)
					{{ Form::open(array('route' => array('internships.create', $applic->student->id), 'method' => 'GET')) }}
					{{ Form::hidden('name', $applic->student->name) }}
					{{ Form::hidden('last_name', $applic->student->last_name) }}
					{{ Form::hidden('student_id', $applic->student->id) }}
					{{ Form::hidden('applic_id', $applic->id) }}
					{{ Form::submit('Izradi praksu', ['class' => 'btn btn-primary btn-sm']) }}
					{{ Form::close() }}
				@endif
				<form action="{{ url('/applic/delete/' . $applic->id) }}" method="POST">
					{{ csrf_field() }}
					<button type="button" data-info="{{ $applic->student->name . ' ' . $applic->student->last_name }}" class="btn btn-danger btn-sm delete" >Ukloni</button>
				</form>
			</div>
			<div class="little_info">
			Datum stvaranja: {{ $applic->created_at->format('d. m. Y. h:i:s') }}<br/>
			Zadnja izmjena: {{ $applic->updated_at->format('d. m. Y. h:i:s') }}</br></br>
			Iz natječaja: {{ isset($applic->competition->name) ? $applic->competition->name : ''}}{{ ', ' . $applic->competition->created_at->format('d. m. Y.') }}</br>
			Potvrđena praksa:
			@if($applic->confirmedInternship())
			<a class="link_object" href="{{ url('/internships/' . $applic->confirmedInternship()->id) }}">{{ $applic->confirmedInternship()->company->name }}</a>
			@else
				Ne
			@endif
			</div>
			<table class="table table-striped table-bordered">
				<tr><th colspan="2" class="table_section">Osobni podaci</th></tr>
				<tr><th>Ime:</th><td>{{ $applic->student->name }}</td></tr>
				<tr><th>Prezime</th><td>{{ $applic->student->last_name }}</td></tr>
				<tr><th>E-mail:</th><td>{{ $applic->email }}</td></tr>
				<tr><th>Mjesto prebivališta:</th><td>{{ $applic->residence_town }}</td></tr>
				<tr><th>Županija prebivališta:</th><td>{{ Utilities::county($applic->residence_county) }}</td></tr>
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
						<b>Razdoblje:</b> {{ $activity->year }} <br/>
						<b>Opis:</b> {{ $activity->description }}
					@endforeach
					</td>
				</tr>
			</table>
        </div>
    </div>
</div>
@endsection

@section('modal_body_content')
	Ukoliko uklonite prijavu bit će uklonjena i pripadajuća praksa. Želite ukloniti prijavu studenta/ice
@endsection