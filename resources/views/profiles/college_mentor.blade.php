@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr><th>Ime</th><td>{{ $user->name }}</td></tr>
					<tr><th>Prezime</th><td>{{ $user->last_name }}</td></tr>
					<tr><th>Titula</th><td>{{ $user->profile->title }}</td></tr>
					<tr><th>Područje</th>{{ $user->profile->fields}}</td></tr>
				
					@if (Auth::user()->id == $user->id || Auth::user()->isAdmin())
					<tr>
						<td>
							<a href="{{ url('user/'. $user->id . '/editcollege') }}"><button class="btn btn-info btn-sm" >Uredi</button></a>
						@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-default btn-sm" >Ukloni</button>
							</form>
						</td>			
					</tr>
					@endif
					@endif
					
				</table>
        </div>
    </div>
</div>
@endsection
