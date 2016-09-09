@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Mentori nastavnici</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($users) == 0)
				<h3 style="text-align:center;color:gray;">Nema registriranih studenata.</h3>
			@endif
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Ime i prezime</th>
						<th>Područje</th>
						<th>Datum registracije</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td><a class="link_object" href="{{ url('user/'. $user->id) }}">{{ $user->name . " " . $user->last_name }}</td>
						<td>{{ Utilities::course($user->profile->fields) }}</td>
						<td>{{ $user->created_at->format('d-m-Y') }}</td>
						<td class="row_buttons">
							<a type="button" class="btn btn-info btn-sm" href="{{ url('/user/' . $user->id) }}">Profil</a>
						@if (Auth::user()->isAdmin())
							<a type="button" class="btn btn-warning btn-sm" href="{{ url('/user/' . $user->id . '/editintern') }}">Uredi</a>
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm">Ukloni</button>
							</form>
						@endif
						</td>
						
					</tr>
					@endforeach
				</tbody>	
				</table>
				<div class="pagination">{{ $users->links() }}</div>
			</div>
        </div>
    </div>
</div>
@endsection
