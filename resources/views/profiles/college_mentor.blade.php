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
#add_mentor {
	width: 100%;
	padding: 2px;
	font-size: 12px;
	margin-top: 5px;
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
					<tr><th>Titula:</th><td>{{ $user->profile->title }}</td></tr>
					<tr><th>Područje:</th><td>{{ Utilities::course($user->profile->fields) }}</td></tr>
					<tr><th>Mentorira studente:</th>
						<td>
						@foreach($internships as $internship) 
						<a href="{{url('/internship/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a><br/>
						@endforeach
						</td>
					</tr>

					
				</table>
			<div class="action_buttons">
				<a href="{{ url('user/'. $user->id . '/editcollege') }}"><button class="btn btn-warning" >Uredi</button></a>	
				<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
					{{ csrf_field() }}
					<button class="btn btn-danger" >Ukloni</button>
				</form>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection
