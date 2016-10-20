@extends('layouts.app')

@section('style')
td:first-child {
	width: 10px;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
		<div class="row">
			<div class="col-md-9 col-sm-8"></div>
			<div class="col-md-3 col-sm-4">
				@if(isset($user->role))
				<form action="{{ url('/user_internships/' . $user->id) }}" method="GET">
				<div class="input-group">
						@if($user->role == 'student')
				        <input type="text" name="search" class="form-control" placeholder="Pretraži po tvrtki..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"></input>
						@else
							<input type="text" name="search" class="form-control" placeholder="Pretraži po studentu/tvrtki..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"></input>
						@endif
				@else
				<form action="{{ url('/company_internships/' . $user->id) }}" method="GET">
				<div class="input-group">
				        <input type="text" name="search" class="form-control" placeholder="Pretraži po studentu..." value="{{isset($_GET['search']) ? $_GET['search'] : ''}}"></input>
				@endif
					    <span class="input-group-btn">
					      	<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					    </span>
				    </div>			  	
				</form>	
			</div>
		</div>
			<h1>{{ $user->name . ' ' . $user->last_name }} - prakse</h1>
			@if(count($internships) == 0 && !isset($_GET['search']))
				@if($user->id == Auth::user()->id)
					<h3>Niste imali niti jednu praksu do sada.</h3>
				@else
					@if(isset($user->role))
						<h3 class="notice">Korisnik do sada nije imao niti jednu praksu.</h3>
					@else
						<h3 class="notice">Tvrtka do sada nije imala niti jednu praksu.</h3>
					@endif					
				@endif
			@elseif(count($internships) == 0)
				<h3 style="text-align:center;color:gray;">Nema rezultata.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						@if(!isset($user->role) || $user->role != 'student')
						<th>Student</th>
						@endif
						<th>Tvrtka</th>
						<th>Natječaj</th>
						<th>Razdoblje prakse</th>				
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($internships as $internship)
					<tr>
						<td>
							@if(strtotime($internship->start_date) > strtotime(date('d-m-Y')))
											<a style="cursor:pointer" data-toggle="tooltip" title="{{ 'Praksa počinje za ' . (strtotime($internship->start_date) - strtotime(date('d-m-Y')))/86400 . ' dana (' . date_create($internship->start_date)->format('d. m. Y.') . ').' }}" class="link_object current_green" ><i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@elseif(strtotime($internship->end_date) > strtotime(date('d-m-Y')))
											<a style="cursor:pointer" data-toggle="tooltip" title="{{ 'Praksa traje još ' . (strtotime($internship->end_date) - strtotime(date('d-m-Y')))/86400 . ' dana (do ' . date_create($internship->end_date)->format('d. m. Y.') . ').'}}" class="link_object current_green" ><i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@else
											<a style="cursor:pointer" data-toggle="tooltip" title="{{ 'Praksa je završila ' . date_create($internship->end_date)->format('d. m. Y.') }}" class="link_object expired_gray" ><i class="fa fa-btn fa-calendar-times-o" aria-hidden="true"></i></a>
										@endif
						</td>	
						@if(!isset($user->role) || $user->role != 'student')
						<td>
						<a  class="link_object" href="{{ url('/user/' . $internship->student_id) }}">{{ $internship->student_full_name }}</a>
						
						</td>
						@endif
						<td><a class="link_object" href="{{ url('/company/profile/' . $internship->company_id) }}">{{ $internship->company_name }}</a></td>
						<td>{{ $internship->competition_name . ', ' . date_create($internship->competition_created_at)->format('d. m. Y.')}}</td>
						<td>{{ date_create($internship->start_date)->format('d. m. Y.') . ' - ' . date_create($internship->end_date)->format('d. m. Y.') }}</td>
						<td class="row_buttons">
							<a class="btn btn-info btn-sm" type="button" href="{{ url('/internships/'. $internship->id) }}">Prikaži</a>
						@if (Auth::user()->isAdmin())	
							<form action="{{ url('/user/'. $internship->student_id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button type="button" data-info="{{ $internship->student_full_name . ' - ' . $internship->company_name }}" class="btn btn-danger btn-sm delete">Ukloni</button>
							</form>
						@endif
						</td>
					</tr>
					@endforeach
				</tbody>	
				</table>
				<div class="pagination">
				@if(isset($_GET['search']))
					{{ $internships->appends(['search' => $_GET['search']])->links() }}
				@else
				{{ $internships->links() }}
				@endif
				</div>
			</div>
			@endif
		</div>
    </div>
</div>
@endsection

@section('modal_body_content')
	Ukloniti praksu 
@endsection
