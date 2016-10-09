@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
		<div class="row">
			<div class="col-md-9 col-sm-8"></div>
			<div class="col-md-3 col-sm-4">
				<form action="{{ url('/user/student/list') }}" method="GET">			
				    <div class="input-group">
				        <input type="text" name="search" class="form-control" placeholder="Pretraži..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"></input>
					    <span class="input-group-btn">
					      	<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					    </span>
				    </div>			  	
				</form>	
			</div>
		</div>
			<h1>Studenti</h1>
			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($users) == 0 && !isset($_GET['search']))
				<h3 style="text-align:center;color:gray;">Nema registriranih studenata.</h3>
			@elseif(count($users) == 0)
				<h3 style="text-align:center;color:gray;">Nema studenata pod tim imenom.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Ime i prezime</th>
						<th>Datum registracije</th>
						<th>Posljednja praksa</th>
						<th>Status natječaja</th>
						<th>Tvrtka</th>					
						<th  ></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>{{ $user->name . " " . $user->last_name }}</td>
						<td>{{ $user->created_at->format('d. m. Y.') }}</td>
						<td>
						@if($user->lastInternship())
							<a class="link_object" href="{{ url('/internships/' . $user->lastInternship()->id) }}">
							@if(strtotime($user->lastInternship()->start_date) > strtotime(date('d-m-Y')))
									<a data-toggle="tooltip" title="{{ 'Praksa počinje za ' . (strtotime($user->lastInternship()->start_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $user->lastInternship()->id)}}">{{ $user->lastInternship()->company->name . ' (' . $user->lastInternship()->competition->year . ')' }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
								@elseif(strtotime($user->lastInternship()->end_date) > strtotime(date('d-m-Y')))
									<a data-toggle="tooltip" title="{{ 'Praksa traje još ' . (strtotime($user->lastInternship()->end_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $user->lastInternship()->id)}}">{{ $user->lastInternship()->company->name . ' (' . $user->lastInternship()->competition->year . ')' }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@else
											<a data-toggle="tooltip" title="{{ 'Praksa je završila ' . date_create($user->lastInternship()->end_date)->format('d. m. Y.') }}" class="link_object expired_gray" href="{{url('/internships/' . $user->lastInternship()->id)}}">{{ $user->lastInternship()->company->name . ' (' . $user->lastInternship()->competition->year . ')' }}</a>
										@endif
							</a>
						@endif
						</td>
						<td>{{ $user->competitionStatus() }}</td>
						<td>
						@if($user->hasCompany())
								<a class="link_object" href="{{ url('/company/profile/' . $user->activeInternship()->company->id) }}" style="color:darkgray">{{ $user->activeInternship()->company->name }}</a>
						@endif
						</td>
						<td class="row_buttons">
						@if($user->activeInternship())
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/internships/'. $user->activeInternship()->id) }}">Prikaži praksu</a>
						@elseif(Utilities::competitionStatus() == 2 && $user->activeApplic())
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
								<button type="button" data-info="{{ $user->name . ' ' . $user->last_name }}" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						</td>
						@endif
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