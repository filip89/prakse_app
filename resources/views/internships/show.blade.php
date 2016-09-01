@extends('layouts.app')

@section('content')

<div class="col-md-4 col-md-offset-4">			
	@foreach($internships as $internship)
		<table class="table">	
			<tbody>
				<tr>
					<td>Ime:</td>
					<td>{{ $internship->student['name'] }}</td>
				</tr>

				<tr>			
					<td>Prezime:</td>
					<td>{{ $internship->student['last_name'] }}</td>
				</tr>

				<tr>
					<td>Mentor iz prakse</td>
					<td>{{ $internship->intern_mentor['name'].' '.$internship->intern_mentor['last_name'] }}</td>
				</tr>

				<tr>
					<td>Mentor nastavnik</td>
					<td>{{ $internship->college_mentor['name'].' '.$internship->college_mentor['last_name'] }}</td>
				</tr>

				<tr>
					<td>Tvrtka:</td>
					<td>{{ $internship->company['name'] }}</td>
				</tr>

				<tr>
					<td>Prosjek ocjena (preddiplomski):</td>
					<td>{{ $internship->average_bacc_grade }}</td>
				</tr>

				<tr>
					<td>Prosjek ocjena (diplomski):</td>
					<td>{{ $internship->average_master_grade }}</td>
				</tr>

				<tr>
					<td>Bodovi izvannastavnih aktivnosti:</td>
					<td>{{ $internship->activity_points }}</td>
				</tr>

				<tr>
					<td>Ukupni bodovi:</td>
					<td>{{ $internship->total_points }}</td>
				</tr>

				<tr>
					<td>Datum početka:</td>
					<td>{{ date('d M, Y', strtotime($internship->start_date)) }}</td>
				</tr>

				<tr>
					<td>Datum završetka:</td>
					<td>{{ date('d M, Y', strtotime($internship->end_date)) }}</td>
				</tr>

				<tr>
					<td>Trajanje prakse:</td>
					<td>{{ $internship->duration }}</td>
				</tr>

				<tr>
					<td>Godina:</td>
					<td>{{ $internship->year }}</td>
				</tr>

				<tr>
					<td>Komentar studenta:</td>
					<td>{{ $internship->student_comment }}</td>
				</tr>

				<tr>
					<td>Studentova ocjena prakse:</td>
					<td>{{ $internship->rating_by_student }}</td>
				</tr>

				<tr>
					<td>Komentar mentora iz prakse:</td>
					<td>{{ $internship->intern_mentor_comment }}</td>
				</tr>

				<tr>
					<td>Komentar mentora nastavnika:</td>
					<td>{{ $internship->college_mentor_comment }}</td>	
				</tr>
			</tbody>
		</table>
	
	@endforeach

	<a href="{{ route('internships.index') }}"><button class="btn btn-primary">Povratak</button></a>	

</div>

@endsection