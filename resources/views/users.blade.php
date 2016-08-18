@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr>
						<th>Ime</th>
						<th>Prezime</th>
					</tr>
					
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->last_name }}</td>
						<td>
						@if ($user->role != "student")
						<a href="user/{{ $user->id }}"><button class="btn btn-info btn-sm">Profil</button></a>
						@else
						<a href="#"><button class="btn btn-info btn-sm">Prijava</button></a>
						@endif
						</td>
						@if (Auth::user()->isAdmin())
						<td>	
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
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
@endsection
