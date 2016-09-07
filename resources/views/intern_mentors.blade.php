@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Mentori iz tvrtke</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			<a href="{{ url('/user/add/internmentor') }}"><button id="add_button" class="btn btn-primary btn-sm"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj mentora</button></a>
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Ime i prezime</th>
						<th>Tvrtka</th>
						<th>Datum registracije</th>
						<th></th>
					</tr>
				</thead>
				<tbody>				
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td><a class="link_object" href="{{ url('/user/' . $user->id) }}">{{ $user->name . " " . $user->last_name }}</a></td>
						<td><a class="link_object" href="{{ url('/company/profile/' . $user->profile->company->id) }}">{{ $user->profile->company->name }}</a></td>

						<td>{{$user->created_at->format('d-m-Y')}}</td>
						<td class="row_buttons">
							<a type="button" class="btn btn-info btn-sm" href="{{ url('/user/' . $user->id) }}">Profil</a>
						@if (Auth::user()->isAdmin())
							<a type="button" class="btn btn-warning btn-sm" href="{{ url('/user/' . $user->id . '/editintern') }}">Uredi</a>
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						@endif
						</td>
						
					</tr>
					@endforeach
				</tbody>
				</table>
			</div>
        </div>
    </div>
</div>
@endsection
