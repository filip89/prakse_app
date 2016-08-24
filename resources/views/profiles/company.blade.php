@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr><th>Naziv tvrtke</th><td>{{ $company->name }}</td></tr>
					<tr><th>Sjedište</th><td>{{ $company->residence }}</td></tr>
					<tr><th>E-mail</th><td>{{ $company->email }}</td></tr>
					<tr><th>Telefon</th><td>>{{ $company->phone }}</td></tr>
					<tr><th>Mentori</th>
						<td>
						<a href="{{ url('/user/add/internmentor/' . $company->id) }}">Dodaj mentora iz tvrtke</a><br/>
						@foreach($company->intern_mentors as $mentor)
							<a href='/user/{{$mentor->user->id}}'>{{$mentor->user->name . ' ' . $mentor->user->last_name}}</a><br/>
						@endforeach
						</td>
					</tr>
					<tr><th>Studenti</th>
						<td>
							@foreach($company->internships as $internship)
								@if($internship->confirmed == 1)
									{{$internship->student->name . ' ' . $internship->student->last_name}}<br/>
								@endif
							@endforeach
						</td>
					</tr>
					<tr>
						<td>
							<a href="{{ url('/company/edit/' . $company->id) }}"><button class="btn btn-info btn-sm" >Uredi</button></a>	
							<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-default btn-sm" >Ukloni</button>
							</form>
						</td>			
					</tr>
				</table>
        </div>
    </div>
</div>
@endsection
