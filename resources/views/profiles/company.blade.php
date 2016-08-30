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
				<table class="table table-striped table-bordered">
					<tr><th>Naziv tvrtke:</th><td>{{ $company->name }}</td></tr>
					<tr><th>Sjedište:</th><td>{{ $company->residence }}</td></tr>
					<tr><th>E-mail:</th><td>{{ $company->email }}</td></tr>
					<tr><th>Telefon:</th><td>{{ $company->phone }}</td></tr>
					<tr><th>Mentori:</th>
						<td>
						@foreach($company->intern_mentors as $mentor)
							<a href="{{ url('/user/' . $mentor->user->id) }}">{{$mentor->user->name . ' ' . $mentor->user->last_name}}</a><br/>
						@endforeach
						<a href="{{ url('/user/add/internmentor/' . $company->id) }}"><button class="btn btn-primary" id="add_mentor">Dodaj mentora iz tvrtke</button></a><br/>
						</td>
					</tr>
					<tr><th>Studenti</th>
						<td>
							@foreach($company->internships as $internship)
								@if($internship->confirmation_student == 1)
									<a href="{{url('/internship/' . $internship->id)}}">{{$internship->student->name . ' ' . $internship->student->last_name}}</a><br/>
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
					<button class="btn btn-danger" >Ukloni</button>
				</form>
			</div>
        </div>
    </div>
</div>
@endsection
