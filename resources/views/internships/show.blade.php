@extends('layouts.app')

@section('style')
a {
	display: block;
	margin-right: 10px;
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
.btn-box {
	display: flex;
	flex-direction: row;
	width: 100%;
	justify-content: space-between;
	margin-bottom: 30px;
}
.action-btn {
	display: flex;
	flex-direction: row;
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
table:nth-of-type(1)  {
	margin-top: 20px;
}
.comment_box {
	width: 40%;
}
@endsection

@section('content')

<div class="col-md-4 col-md-offset-4">	

	@foreach($internships as $internship)

		<h1>Praksa br. {{ $internship->id }}</h1>

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
			</table>
		
	@endforeach

	<div class="btn-box">

		<div class="return-btn"><a href="{{ route('internships.index') }}" class="btn btn-primary btn-sm">Povratak</a></div>

		<div class="action-btn">
			<a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Uredi</a>

			{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
				<button type ="button" class="btn btn-danger btn-sm delete">Ukloni</button>
			{{ Form::close() }}

		</div>	

	</div>

</div>

@endsection

