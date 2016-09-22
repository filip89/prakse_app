@extends('layouts.app')

@section('style')
a {
	display: block;
}
th {
	font-size: 16px;
}
table, th {
	text-align: center;
}
h1 {
	text-align: center;
}
.action_buttons {
	display: table;
	margin: auto;
}
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
.optional {
	text-decoration: none;
}
table:nth-of-type(1)  {
	margin-top: 20px;
}
.comment_box {
	width: 40%;
}
.doc_info {
	font-size: 13px;
}
.doc_title {
	text-decoration: underline;
}
@endsection

@section('content')

<div class="col-md-4 col-md-offset-4">	

	@foreach($internships as $internship)

		@if(isset($paginate) == 1)<div class="pagination">{{ $internships->render() }}</div>@endif
		@if($internship->student->id == Auth::user()->id)
			<a type="button" style="float:right;margin-bottom:20px" class="btn btn-bg btn-default" href="/user_internships"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Prijašnje prakse</a>
		@endif
		<h1 style="clear:both;">Praksa br. {{ $internship->id }}</h1>
		
		@if(Auth::user()->isadmin())
		<div class="action_buttons">
			<a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Uredi</a>
			
			{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
				<button type ="button" class="btn btn-danger btn-sm delete">Ukloni</button>
			{{ Form::close() }}
		</div>
		@endif

		<table class="table table-striped table-bordered">
				<tr><th colspan="2" class="table_section">Osobni podaci</th></tr>
				<tr><th>Ime:</th><td>{{ $internship->student['name'] }}</td></tr>
				<tr><th>Prezime</th><td>{{ $internship->student['last_name'] }}</td></tr>
				<tr><th>E-mail</th><td>{{ $internship->student['email'] }}</td></tr>
				
				<tr><th colspan="2" class="table_section">Akademski podaci</th></tr>
				<tr><th>Prosjek na preddiplomskom:</th><td>{{ $internship->average_bacc_grade }}</td></tr>
				<tr><th>Prosjek na diplomskom:</th><td>{{ $internship->average_master_grade }}</td></tr>
				<tr><th>Izvannastavne aktivnosti:</th><td>{{ $internship->activity_points }}</td></tr>
				<tr><th>Ukupno ostvareni bodovi:</th><td>{{ $internship->total_points }}</td></tr>
				<tr><th colspan="2" class="table_section">Praksa</th></tr>
				<tr><th>Tvrtka:</th><td>{{ $internship->company['name'] }}</td></tr>
				<tr><th>Mentor iz prakse:</th><td>{{ $internship->intern_mentor['name'].' '.$internship->intern_mentor['last_name'] }}</td></tr>
				<tr><th>Trajanje prakse:</th><td>{{ $internship->duration }}</td></tr>
				<tr><th>Godina prakse:</th><td>{{ $internship->year }}</td></tr>
				<tr><th>Datum početka prakse:</th><td>{{ date('d M, Y', strtotime($internship->start_date)) }}</td></tr>
				<tr><th>Datum završetka prakse:</th><td>{{ date('d M, Y', strtotime($internship->end_date)) }}</td></tr>
				<tr><th>Studentova ocjena prakse:</th><td>{{ $internship->rating_by_student }}</td></tr>
				<tr><th colspan="2" class="table_section">Komentari</th></tr>
				<tr><th>Komentar studenta:</th><td class="comment_box">{{ $internship->student_comment }}</td></tr>
				<tr><th>Komentar mentora nastavnika:</th><td class="comment_box">{{ $internship->college_mentor_comment }}</td></tr>
				<tr><th>Komentar mentora iz prakse:</th><td class="comment_box">{{ $internship->intern_mentor_comment }}</td></tr>
				@if(Auth::user()->id === $internship->college_mentor_id && Auth::user()->role == 'college_mentor' || Auth::user()->role == 'intern_mentor' || Auth::user()->isAdmin()) 
					<tr><th colspan="2" class="table_section optional"><span class="doc_title">Dokumenti</span><br><span class="doc_info">(Za generiranje dokumenata potrebno je studentu dodijeliti tvrtku, mentora nastavnika te odrediti trajanje prakse)</span></th></tr> 
				@endif

				@if(Auth::user()->id === $internship->college_mentor_id && Auth::user()->role == 'college_mentor' || Auth::user()->isAdmin())	
					<tr><th>Uputnica za studentsku stručnu praksu:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="1">
							<button type="submit" class="btn btn-success fa-sm" 
							@if($internship->company_id == null || $internship->duration == null || $internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
						</form>
					</td></tr>
					<tr><th>Potvrda o obavljenoj edukaciji:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="3">
							<button type="submit" class="btn btn-success fa-sm" 
							@if($internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
						</form>
					</td></tr>
				@endif

				@if(Auth::user()->role == 'intern_mentor' || Auth::user()->isAdmin())
					<tr><th>Potvrda o obavljenoj praksi:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="2">
							<button type="submit" class="btn btn-success fa-sm"
							@if($internship->company_id == null || $internship->duration == null || $internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o fa-" aria-hidden="true"></i></button>
						</form>
					</td></tr>
				@endif

			</table>
		
	@endforeach

	<div class="action_buttons"><a href="{{ route('internships.index') }}" class="btn btn-primary btn-sm">Povratak</a></div><br>

</div>

@endsection

