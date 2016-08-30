@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
				<div class="table-responsive">
					<table class="table table-striped">
					<tr>
						<th>Ime i prezime</th>
						<th>Područje</th>
						<th></th>
					</tr>
					
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td><a href="{{ url('user/'. $user->id) }}">{{ $user->name . " " . $user->last_name }}</td>
						<td>{{ Utilities::course($user->profile->fields) }}</td>
						<td>
						@if (Auth::user()->isAdmin())
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger btn-sm">Ukloni</button>
							</form>
						@endif
						</td>
						
					</tr>
					@endforeach
					
				</table>
				</div>
        </div>
    </div>
</div>
@endsection
