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
}
.action-btn {
	display: flex;
	flex-direction: row;


}
@endsection

@section('content')

<div class="col-md-4 col-md-offset-4">	

	@foreach($internships as $internship)

		<h1>Praksa br. {{ $internship->id }}</h1>

		<table class="table table-striped">	
			<tbody>
				<tr>
					<td><th>Ime:</th></td>
					<td>{{ $internship->student['name'] }}</td>
				</tr>

				<tr>			
					<td><th>Prezime:</th></td>
					<td>{{ $internship->student['last_name'] }}</td>
				</tr>

				<tr>
					<td><th>Mentor iz prakse:</th></td>
					<td>{{ $internship->intern_mentor['name'].' '.$internship->intern_mentor['last_name'] }}</td>
				</tr>

				<tr>
					<td><th>Mentor nastavnik:</th></td>
					<td>{{ $internship->college_mentor['name'].' '.$internship->college_mentor['last_name'] }}</td>
				</tr>

				<tr>
					<td><th>Tvrtka:</th></td>
					<td>{{ $internship->company['name'] }}</td>
				</tr>

				<tr>
					<td><th>Prosjek ocjena (preddiplomski):</th></td>
					<td>{{ $internship->average_bacc_grade }}</td>
				</tr>

				<tr>
					<td><th>Prosjek ocjena (diplomski):</th></td>
					<td>{{ $internship->average_master_grade }}</td>
				</tr>

				<tr>
					<td><th>Bodovi izvannastavnih aktivnosti:</th></td>
					<td>{{ $internship->activity_points }}</td>
				</tr>

				<tr>
					<td><th>Ukupni bodovi:</th></td>
					<td>{{ $internship->total_points }}</td>
				</tr>

				<tr>
					<td><th>Datum početka:</th></td>
					<td>{{ date('d M, Y', strtotime($internship->start_date)) }}</td>
				</tr>

				<tr>
					<td><th>Datum završetka:</th></td>
					<td>{{ date('d M, Y', strtotime($internship->end_date)) }}</td>
				</tr>

				<tr>
					<td><th>Trajanje prakse:</th></td>
					<td>{{ $internship->duration }}</td>
				</tr>

				<tr>
					<td><th>Godina:</th></td>
					<td>{{ $internship->year }}</td>
				</tr>

				<tr>
					<td><th>Studentova ocjena prakse:</th></td>
					<td>{{ $internship->rating_by_student }}</td>
				</tr>

				<tr>
					<td><th>Komentar studenta:</th></td>
					<td>{{ $internship->student_comment }}</td>
				</tr>



				<tr>
					<td><th>Komentar mentora iz prakse:</th></th></td>
					<td>{{ $internship->intern_mentor_comment }}</td>
				</tr>

				<tr>
					<td><th>Komentar mentora nastavnika:</th></td>
					<td>{{ $internship->college_mentor_comment }}</td>	
				</tr>
			</tbody>
		</table>
		
	@endforeach

	<div class="btn-box">

		<div class="return-btn"><a href="{{ route('internships.index') }}" class="btn btn-primary btn-sm">Povratak</a></div>

		<div class="action-btn">
			<a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Uredi</a>

			{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
				<button class="btn btn-danger btn-sm">Ukloni</button>
			{{ Form::close() }}
		</div>	

	</div>

</div>

@endsection