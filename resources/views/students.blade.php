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
			@if(count($users) == 0)
				<h3 style="text-align:center;color:gray;">Nema registriranih studenata.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Ime i prezime</th>
						<th>Tvrtka</th>
						<th>Datum registracije</th>	
						<th>Status natječaja</th>						
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>{{ $user->name . " " . $user->last_name }}</td>
						<td>
						@if($user->confirmedInternship() && isset($user->internship->company))
							<a class="link_object" href="{{ url('/company/profile/' . $user->activeInternship()->company->id) }}">{{ $user->activeInternship()->company->name }}</a></td>							
						@endif
						<td>{{ $user->created_at->format('d-m-Y') }}</td>
						<td>{{ $user->competitionStatus() }}</td>
						<td class="row_buttons">
						@if($user->activeInternship())
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/internships/'. $user->activeInternship()->id) }}">Prikaži praksu</a>
						@elseif($user->activeApplic())
						{{ Form::open(array('route' => array('internships.create'), 'method' => 'GET')) }}
							{{ Form::hidden('name', $user->name) }}
							{{ Form::hidden('last_name', $user->last_name) }}
							{{ Form::hidden('student_id', $user->id) }}
							{{ Form::hidden('applic_id', $user->activeApplic()->id) }}
							{{ Form::submit('Izradi praksu', ['class' => 'btn btn-primary btn-sm']) }}
						{{ Form::close() }}
						@endif
						@if (Auth::user()->isAdmin())	
							<form action="{{ url('/user/'. $user->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>	
				</table>
				<div class="pagination">{{ $users->links() }}</div>
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
