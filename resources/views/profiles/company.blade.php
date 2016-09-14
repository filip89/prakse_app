@extends('layouts.app')

@section('style')
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
        <div class="col-md-6 col-md-offset-3">
		@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-btn fa-briefcase" aria-hidden="true"></i>Tvrtke</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table profile_table">
							<tr><th>Naziv tvrtke:</th><td>{{ $company->name }}</td></tr>
							<tr><th>Sjedište:</th><td>{{ $company->residence }}</td></tr>
							<tr><th>E-mail:</th><td>{{ $company->email }}</td></tr>
							<tr><th>Telefon:</th><td>{{ $company->phone }}</td></tr>
							<tr><th>Mentori:</th>
								<td>
								@foreach($company->intern_mentors as $mentor)
									<a class="link_object" href="{{ url('/user/' . $mentor->user->id) }}">{{$mentor->user->name . ' ' . $mentor->user->last_name}}</a><br/>
								@endforeach
								@if(Auth::user()->isAdmin())
								<a type="button"  id="add_mentor" class="btn btn-primary" href="{{ url('/user/add/internmentor/' . $company->id) }}"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj mentora iz tvrtke</a><br/>
								@endif
								</td>
							</tr>
							<tr><th>Studenti:</th>
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
					</div>
					@if(Auth::user()->isAdmin() || Auth::user()->profile->company->id == $company->id)
					<div class="action_buttons">
						<a href="{{ url('/company/edit/' . $company->id) }}"><button class="btn btn-warning" >Uredi</button></a>
					@endif
					@if(Auth::user()->isAdmin())
						<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
							{{ csrf_field() }}
							<button type="button" class="btn btn-danger delete" >Ukloni</button>
						</form>
					</div>
					@endif
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
