@extends('layouts.app')

@section('style')
form {
	display: inline;
}
.action_buttons {
	display: table;
	margin: auto;
}
table {
	margin-top: 30px;
	text-align: center;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
			<div class="table-responsive">
				<table class="table table-striped">
					<tr><th>Ime:</th><td>{{ $user->name }}</td></tr>
					<tr><th>Prezime:</th><td>{{ $user->last_name }}</td></tr>
					<tr><th>Radno mjesto:</th><td>{{ $user->profile->job_description }}</td></tr>
					<tr><th>Telefon:</th><td>{{ $user->profile->phone }}</td></tr>
					<tr><th>Tvrtka:</th>
						<td>
						@if(!is_null($user->profile->company)) 
						<a href="{{url('/company/profile/' . $user->profile->company->id)}}">{{ $user->profile->company->name }}</a>
						@endif 
						</td>
					</tr>
					<tr><th>Mentorira studente:</th>
						<td>
						@foreach($internships as $internship) 
						<a href="{{url('/internship/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a><br/>
						@endforeach
						</td>
					</tr>
					
				</table>
				@if (Auth::user()->id == $user->id || Auth::user()->isAdmin())
					<div class="action_buttons">
						<a href="{{ url('user/'. $user->id . '/editintern') }}"><button class="btn btn-info btn-sm" >Uredi</button></a>
						@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)	
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-default btn-sm" >Ukloni</button>
							</form>
					</div>
					@endif
				@endif	
			</div>
        </div>
    </div>
</div>
@endsection
