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
        <div class="col-md-4 col-md-offset-4">
		@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
			<div class="panel panel-info">
				<div class="panel-heading">Profil tvrtke</div>
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
								<a type="button"  id="add_mentor" class="btn btn-primary" href="{{ url('/user/add/internmentor/' . $company->id) }}"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj mentora iz tvrtke</a><br/>
								</td>
							</tr>
							<tr><th>Studenti:</th>
								<td>
									@foreach($company->internships as $internship)
										@if($internship->confirmation_student == 1)
											<a class="link_object" href="{{url('/internship/' . $internship->id)}}">{{$internship->student->name . ' ' . $internship->student->last_name}}</a><br/>
										@endif
									@endforeach
								</td>
							</tr>
						</table>
					</div>
					<div class="action_buttons">
						<a href="{{ url('/company/edit/' . $company->id) }}"><button class="btn btn-warning" >Uredi</button></a>	
						<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
							{{ csrf_field() }}
							<button class="btn btn-danger delete" >Ukloni</button>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
