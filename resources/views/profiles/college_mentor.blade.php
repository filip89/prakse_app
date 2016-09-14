@extends('layouts.app')

@section('style')


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
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-btn fa-user" aria-hidden="true"></i>Mentor nastavnik</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table profile_table">
							<tr><th>Ime:</th><td>{{ $user->name }}</td></tr>
							<tr><th>Prezime:</th><td>{{ $user->last_name }}</td></tr>
							<tr><th>Titula:</th><td>{{ $user->profile->title }}</td></tr>
							<tr><th>Područje:</th><td>{{ Utilities::course($user->profile->fields) }}</td></tr>
							<tr><th>Mentorira studente:</th>
								<td>
								@foreach($internships as $internship) 
								<div class="student_item">
								@if($internship->confirmation_student == 1)
									<a class="link_object confirmed_green" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
								@endif
								</div>
								@endforeach
								@foreach($internships as $internship) 
								<div class="student_item">
								@if($internship->confirmation_student != 1)
									<a class="link_object unconfirmed_gray" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
								@endif
								</div>
								@endforeach
								</td>
							</tr>		
						</table>
					@if(Auth::user()->isAdmin() || Auth::user()->id == $user->id)
					<div class="action_buttons">
						<a href="{{ url('user/'. $user->id . '/editcollege') }}"><button class="btn btn-warning" >Uredi</button></a>
						@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)							
						<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
							{{ csrf_field() }}
							<button type="button" class="btn btn-danger delete" >Ukloni</button>
						</form>
						@endif
					</div>
					@endif
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
