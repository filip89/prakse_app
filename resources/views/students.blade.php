@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
				<div class="table-responsive">
					<table class="table table-striped">
					<tr>
						<th>Ime</th>
						<th>Prezime</th>
						<th>Datum registracije</th>
						<th>Status</th>
						<th></th>
					</tr>
					
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->last_name }}</td>
						<td>{{$user->created_at->format('d-m-Y')}}</td>
						<td>
						@if(isset($user->internship))
							<a href="{{ url('/internship/'. $user->internship->id) }}"><button class="btn btn-primary btn-sm">Izrađena praksa</button></a>
						@elseif(isset($user->applic))
							<a href="{{ url('/apply/'. $user->id) }}"><button class="btn btn-info btn-sm">Izrađena prijava</button></a>
						@endif
						</td>
						@if (Auth::user()->isAdmin())
						<td>	
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
