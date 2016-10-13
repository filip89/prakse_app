@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
		@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
		@if($errors->first('image_file'))
			<div class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ $errors->first('image_file') }}
			</div>
		@endif
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-btn fa-user" aria-hidden="true"></i>Student
				</div>
				<div class="panel-body">
				@if(Auth::user()->isAdmin() || Auth::user()->id == $user->id)
					<div style="clear:both;" class="action_buttons">
						<a href="{{ url('user/'. $user->id . '/editstudent') }}"><button class="btn btn-warning" >Uredi</button></a>
						@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)							
						<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
						{{ csrf_field() }}
							<button type="button" class="btn btn-danger delete" >Ukloni</button>
						</form>
						@endif
					</div>
				@endif
					
					<div class="table-responsive">
						<table class="table profile_table">
							<tr>
								<td rowspan='6'>
								<div class="profile_img_container">
									@if($user->image)
									<img style="max-height:200px;max-width:200px;" src="/images/profile/{{ $user->image }}" />
									@else
									<img style="max-height:200px;max-width:200px;" src="/images/profile/empty_profile.png" />
									@endif
									@if(Auth::user()->id == $user->id)
										@if($user->image)
										<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#profile_addImg_modal">Promijeni</button>
										@else
										<button class="btn btn-primary btn-sm" style="opacity:1;" data-toggle="modal" data-target="#profile_addImg_modal">Dodaj sliku</button>
										@endif	
									@endif
									@if(Auth::user()->id == $user->id || Auth::user()->isAdmin())
										@if($user->image)
										<form action="{{ url('/user/image/delete/' . $user->id) }}" method="POST">
										{{ csrf_field() }}
										<button type="button" data-toggle="tooltip" title="Ukloni" datadata-info="{{ $user->id }}" class="btn btn-danger btn-sm delete_img" ><i class="fa fa-times" aria-hidden="true"></i></button>
										</form>
										@endif
									@endif
									</img>
								</div>
								</td>
								<th>Ime:</th><td>{{ $user->name }}</td>
							</tr>
							<tr><th>Prezime:</th><td>{{ $user->last_name }}</td></tr>
							<tr><th>E-mail:</th><td>{{ $user->email }}</td></tr>
							<tr><th>Telefon:</th><td>{{ $user->phone }}</td></tr>
							<tr></tr>
							<tr></tr>
							@if(Auth::user()->role == 'college_mentor')
							<tr>
								<th>Status prijave: </th>
								<td colspan="2">
								@if($user->activeApplic())
								<a href="{{ url('/applic/' . $user->activeApplic()->id) }}">{{ $user->competitionStatus() }}</a>
								@else
								{{ $user->competitionStatus() }}
								@endif
								</td>
							</tr>
							<tr>
								<th>Posljednja praksa: </th>
								<td colspan="2">
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
							</tr>

							<tr>
								<th><b>Broj praksi: </b></th>
								<th><b>Broj prijava: </b></th>
								<th style="width:33%;"><b>Student odbio: </b></th>
							</tr>
							<tr>
								<th>{{ $internshipsNum }}</th>
								<th>{{ $applicsNum }}</th>
								<th>{{ $internshipsTurnedDown }}</th>
							</tr>
							@endif							
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection

@section('modal_body_content')
	Ukloniti studenta
@endsection