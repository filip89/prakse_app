@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Studenti</h1>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Ime i prezime</th>
						<th>Tvrtka</th>
						<th>Datum registracije</th>		
						<th></th>
					</tr>
					
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td>{{ $user->name . " " . $user->last_name }}</td>
						<td>
						@if(isset($user->internship->company))
							<a href="{{ url('/company/profile/' . $user->internship->company->id) }}">{{ $user->internship->company->name }}</a></td>
						@endif
						<td>{{$user->created_at->format('d-m-Y')}}</td>
						<td class="row_buttons">
						@if(isset($user->internship))
							<a class="btn btn-primary btn-sm" type="button" href="{{ url('/internships/'. $user->internship->id) }}">Pogledaj praksu</a>
						@elseif(isset($user->applic))
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/apply/'. $user->id) }}">Pogledaj prijavu</a>
						@endif
						@if (Auth::user()->isAdmin())	
							<form action="{{ url('/user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger btn-sm">Ukloni</button>
							</form>
						</td>
						@endif
					</tr>
					@endforeach
					
				</table>
			</div>
        </div>
    </div>
</div>
@endsection
