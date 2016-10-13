@extends('layouts.app')

@section('style')
form {
	display: inline;
}

table {
	margin-top: 30px;
	text-align: center;
}

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
				<div class="panel-heading"><i class="fa fa-btn fa-user" aria-hidden="true"></i>Mentor iz tvrtke</div>
				<div class="panel-body">
					@if (Auth::user()->id == $user->id || Auth::user()->isAdmin())
						<div class="action_buttons">
							<a href="{{ url('user/'. $user->id . '/editintern') }}"><button class="btn btn-warning" >Uredi</button></a>
							@if (Auth::user()->isAdmin() && Auth::user()->id != $user->id)	
								<form action="{{ url('user/'. $user->id . '/delete') }}" method="POST">
									{{ csrf_field() }}
									<button type="button" class="btn btn-danger delete" >Ukloni</button>
								</form>
							@endif
						</div>
					@endif
					<div class="table-responsive">
						<table class="table">
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
										<button type="button" data-info="{{ $user->id }}" class="btn btn-danger btn-sm delete_img" >Ukloni</button>
										</form>
										@endif
									@endif
									</img>
								</div>
								</td>
								<th>Ime:</th><td>{{ $user->name }}</td>
							</tr>
							<tr><th>Ime:</th><td>{{ $user->name }}</td></tr>
							<tr><th>Prezime:</th><td>{{ $user->last_name }}</td></tr>
							<tr><th>Tvrtka:</th>
								<td>
								@if(!is_null($user->profile->company)) 
								<a class="link_object" href="{{url('/company/profile/' . $user->profile->company->id)}}">{{ $user->profile->company->name }}</a>
								@endif 
								</td>
							</tr>
							<tr><th>Telefon:</th><td>{{ $user->phone }}</td></tr>
							<tr><th>Radno mjesto:</th><td>{{ $user->profile->job_description }}</td></tr>
							
							@if(Auth::user()->role == 'college_mentor' || (Auth::user()->role == 'intern_mentor' && (isset(Auth::user()->profile->company) && Auth::user()->profile->company->id == $user->profile->company->id)))
							<tr><td colspan="3" style="text:align:center" colspan="2"><a type="button" class="btn btn-bg btn-default" href="{{ url('/user_internships/' . $user->id) }}"><i class="fa fa-btn fa-folder" aria-hidden="true"></i>Povijest praksi</a></td></tr>
							<tr><th colspan="3" style="text-align:center;font-size:18px" colspan="2"><b>Mentorstva:</b></th></tr>
							<tr>	
								<td>Tekući natječaj:</br>
								@if(Utilities::competitionStatus() == 2)
									@if(count($currentCompInterns) > 0)
										@foreach($currentCompInterns as $internship)
										<div class="user_item">
										<a class="link_object unconfirmed_gray" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
										</div>
										@endforeach
									@else
										@if(Auth::user()->id == $user->id)
										<i><small>Nemate praktikante s tekućeg natječaja</small></i>
										@else
										<i><small>Nema praktikante s tekućeg natječaja</small></i>
										@endif
									@endif
								@elseif(Utilities::competitionStatus() == 0)
									<i><small>Nema tekućeg natječaja</small></i>
								@elseif(Utilities::competitionStatus() == 1)
									<i><small>Natječaj je još otvoren</small></i>
								@endif
								</td>
								<td style="width:5%"></td>
								<td>Nedavne prakse:</br>
								@if(count($recentInterns) == 0)
									@if(Auth::user()->id == $user->id)
									<i><small>Niste imali praktikante u zadnjih 6 mjeseci</small></i>
									@else
									<i><small>Nema praktikante u zadnjih 6 mjeseci</small></i>
									@endif
								@else
									@foreach($recentInterns as $internship)
										
										<div class="user_item">
										@if(strtotime($internship->start_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa počinje za ' . (strtotime($internship->start_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@elseif(strtotime($internship->end_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa traje još ' . (strtotime($internship->end_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@elseif(isset($internship->end_date))
											<a data-toggle="tooltip" title="{{ 'Praksa je završila ' . date_create($internship->end_date)->format('d. m. Y.') }}" class="link_object expired_gray" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
										@endif
										</div>
										
									@endforeach
								@endif
								</td>
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
	Ukloniti mentora
@endsection
