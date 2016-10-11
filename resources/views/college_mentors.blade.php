@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
		<div class="row">
			<div class="col-md-9 col-sm-8"></div>
			<div class="col-md-3 col-sm-4">
				<form action="{{ url('/user/college_mentor/list') }}" method="GET">			
				    <div class="input-group">
				        <input type="text" name="search" class="form-control" placeholder="Pretraži..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"></input>
					    <span class="input-group-btn">
					      	<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					    </span>
				    </div>			  	
				</form>	
			</div>
		</div>
			<h1>Mentori nastavnici</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($users) == 0 && (!isset($_GET['search']) || $_GET['search'] == ''))
				<h3 style="text-align:center;color:gray;">Nema registriranih mentora.</h3>
			@elseif(count($users) == 0 && isset($_GET['search']))
				<h3 style="text-align:center;color:gray;">Nema mentora pod tim imenom.</h3>
			@else
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
						<td>{{ $user->created_at->format('d. m. Y.') }}</td>
						<td class="row_buttons">
							<a type="button" class="btn btn-info btn-sm" href="{{ url('/user/' . $user->id) }}">Profil</a>
							@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" data-info="{{ $user->name . ' ' . $user->last_name }}" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						@endif
						</td>
						
					</tr>
					@endforeach
				</tbody>	
				</table>
				<div class="pagination">
				@if(isset($_GET['search']))
				{{ $users->appends(['search' => $_GET['search']])->links() }}
				@else
				{{ $users->links() }}
				@endif
				</div>
			</div>
			@endif
        </div>
    </div>
</div>
@endsection

@section('modal_body_content')
	Ukloniti korisnika
@endsection