@extends('layouts.app')

@section('style')
td:first-child {
	width: 10px;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>{{ $user->name . ' ' . $user->last_name }} - prakse</h1>
			@if(count($internships) == 0)
				@if($user->id == Auth::user()->id)
					<h3>Niste imali niti jednu praksu do sada.</h3>
				@else
					@if(isset($user->role))
						<h3 class="notice">Korisnik do sada nije imao niti jednu praksu.</h3>
					@else
						<h3 class="notice">Tvrtka do sada nije imala niti jednu praksu.</h3>
					@endif					
				@endif
			@else
				@if($user->role == 'student' && Utilities::competitionStatus() != 0)
					<p>* Navedene prakse su isključivo iz prethodnih natječaja. </p>
				@endif
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						@if(!isset($user->role) || $user->role != 'student')
						<th>Student</th>
						@endif
						<th>Tvrtka</th>
						@if(isset($user->role) && $user->role != 'intern_mentor')
						<th>Mentor iz tvrtke</th>
						@endif
						@if(isset($user->role) && $user->role != 'college_mentor')
						<th>Mentor nastavnik</th>
						@endif
						<th>Natječaj</th>
						<th>Razdoblje prakse</th>				
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($internships as $internship)
					<tr>
						<td>
							@if(strtotime($internship->start_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa počinje za ' . (strtotime($internship->start_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" ><i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@elseif(strtotime($internship->end_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa traje još ' . (strtotime($internship->end_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" ><i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@else
											<a data-toggle="tooltip" title="{{ 'Praksa je završila ' . date_create($internship->end_date)->format('d. m. Y.') }}" class="link_object expired_gray" ><i class="fa fa-btn fa-calendar-times-o" aria-hidden="true"></i></a>
										@endif
						</td>	
						@if(!isset($user->role) || $user->role != 'student')
						<td>
						{{ $internship->student->name . ' ' . $internship->student->last_name }}
						</td>
						@endif
						<td><a class="link_object" href="{{ url('/company/profile/' . $internship->company->id) }}">{{ $internship->company->name }}</a></td>
						@if(isset($user->role) && $user->role != 'intern_mentor')
						<td>
							@if(isset($internship->intern_mentor))
							<a class="link_object" href="{{ url('/user/' . $internship->intern_mentor->id) }}">{{ $internship->intern_mentor->name . ' ' . $internship->intern_mentor->last_name }}</a>
							@endif
						</td>
						@endif
						@if(isset($user->role) && $user->role != 'college_mentor')
						<td>
							@if(isset($internship->college_mentor))
							<a class="link_object" href="{{ url('/user/' . $internship->college_mentor->id) }}">{{ $internship->college_mentor->name . ' ' . $internship->college_mentor->last_name}}</a>
							@endif
						</td>
						@endif
						<td>{{ $internship->competition->name . ', ' . $internship->competition->created_at->format('d. m. Y.')}}</td>
						<td>{{ date_create($internship->start_date)->format('d. m. Y.') . ' - ' . date_create($internship->end_date)->format('d. m. Y.') }}</td>
						<td class="row_buttons">
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/internships/'. $internship->id) }}">Prikaži</a>
						@if (Auth::user()->isAdmin())	
							<form action="{{ url('/user/'. $internship->student->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						@endif
						</td>
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
