@extends('layouts.app')

@section('style')
#add_mentor {
	width: 100%;
	margin-bottom: 20px;
	font-size: 18px;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
			<a href="{{ url('/user/add/internmentor') }}"><button id="add_mentor" class="btn btn-primary btn-sm">Dodaj mentora</button></a>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Ime i prezime</th>
						<th>Tvrtka</th>
						<th></th>
						<th></th>
					</tr>
					
					@foreach ($users as $user)
						@if(Auth::user() == $user)
							@continue
						@endif
					<tr>
						<td><a href="{{ url('/user/' . $user->id) }}">{{ $user->name . " " . $user->last_name }}</a></td>
						<td><a href="{{ url('/company/profile/' . $user->profile->company->id) }}">{{ $user->profile->company->name }}</a></td>
						@if (Auth::user()->isAdmin())
						<td>	
							<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger btn-sm delete">Ukloni</button>
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
