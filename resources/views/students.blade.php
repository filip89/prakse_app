@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Studenti</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
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
						@if(count($user->internships()->where('status', 1)->get()) == 1)
							<a class="link_object" href="{{ url('/company/profile/' . $user->internships()->where('status', 1)->first()->company->id) }}">{{ $user->internships()->where('status', 1)->first()->company->name }}</a></td>
						@endif
						<td>{{$user->created_at->format('d-m-Y')}}</td>
						<td class="row_buttons">
						@if(count($user->internships()->where('status', 1)->get()) == 1)
							<a class="btn btn-primary btn-sm" type="button" href="{{ url('/internships/'. $user->internships()->where('status', 1)->first()->id) }}">Pogledaj praksu</a>
						@elseif(count($user->applics()->where('status', 1)->get()) == 1)
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
