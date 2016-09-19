@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>{{ $user->name . ' ' . $user->last_name }} - prakse</h1>
			@if(count($internships) == 0)
				@if($user->id == Auth::user()->id)
					<h3>Niste imali niti jednu praksu do sada.</h3>
				@else
					<h3 class="notice">Korisnik do sada nije imao niti jednu praksu.</h3>
				@endif
			@else
				@if($user->role == 'student' && Utilities::competitionStatus() != 0)
					<p>* Navedene prakse su isključivo iz prethodnih natječaja. </p>
				@endif
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						@if(isset($user->role) && $user->role != 'student')
						<th>Student</th>
						@endif
						<th>Tvrtka</th>
						<th>Mentor iz tvrtke</th>
						<th>Mentor nastavnik</th>
						<th>Natječaj</th>
						<th>Razdoblje prakse</th>				
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($internships as $internship)
					<tr>
					@if(isset($user->role) && $user->role != 'student')
						<td> {{ $internship->student->name . ' ' . $internship->student->last_name }} </td>
					@endif
						<td><a href="{{ url('/company/profile/' . $internship->company->id) }}">{{ $internship->company->name }}</a></td>
						<td><a href="{{ url('/user/' . $internship->intern_mentor->id) }}">{{ $internship->intern_mentor->name . ' ' . $internship->intern_mentor->last_name }}</a></td>
						<td><a href="{{ url('/user/' . $internship->college_mentor->id) }}">{{ $internship->college_mentor->name . ' ' . $internship->college_mentor->last_name}}</a></td>
						<td>{{ $internship->competition->name . ', ' . $internship->competition->created_at->format('d-m-Y')}}</td>
						<td>{{ date('d M, Y', strtotime($internship->start_date)) . ' - ' . date('d M, Y', strtotime($internship->end_date))}}</td>
						<td class="row_buttons">
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/internships/'. $internship->id) }}">Prikaži</a>
						@if (Auth::user()->isAdmin())	
							<form action="{{ url('/user/'. $internship->student->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>	
				</table>
				<div class="pagination">{{ $internships->links() }}</div>
			</div>
			@endif
		</div>
    </div>
</div>
@endsection