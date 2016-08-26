@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr><th>Ime</th><td>{{ $user->name }}</td></tr>
					<tr><th>Prezime</th><td>{{ $user->last_name }}</td></tr>
					<tr><th>Radno mjesto</th><td>{{ $user->profile->job_description }}</td></tr>
					<tr><th>Telefon</th><td>{{ $user->profile->phone }}</td></tr>
					<tr><th>Tvrtka</th>
						<td>
						@if(!is_null($user->profile->company)) 
						<a href="{{ url('/company/profile/' . $user->profile->company->id) }}">{{ $user->profile->company->name }}</a>
						@endif 
						</td>
					</tr>
					@if (Auth::user()->id == $user->id || Auth::user()->isAdmin())
					<tr>
						<td>
							<a href="{{ url('user/'. $user->id . '/editintern') }}"><button class="btn btn-info btn-sm" >Uredi</button></a>
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
