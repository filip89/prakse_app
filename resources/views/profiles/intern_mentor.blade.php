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
							<tr><th>Ime:</th><td>{{ $user->name }}</td></tr>
							<tr><th>Prezime:</th><td>{{ $user->last_name }}</td></tr>
							<tr><th>Tvrtka:</th>
								<td>
								@if(!is_null($user->profile->company)) 
								<a class="link_object" href="{{url('/company/profile/' . $user->profile->company->id)}}">{{ $user->profile->company->name }}</a>
								@endif 
								</td>
							</tr>
							<tr><th>Radno mjesto:</th><td>{{ $user->profile->job_description }}</td></tr>
							<tr><th>Telefon:</th><td>{{ $user->profile->phone }}</td></tr>
							<tr><td style="text:align:center" colspan="2"><a type="button" class="btn btn-bg btn-default" href="{{ url('/user_internships/' . $user->id) }}"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Povijest praksi</a></td></tr>
							<tr><th style="text-align:center;font-size:18px" colspan="2"><b>Mentorstva:</b></th></tr>
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
										@else
											<a data-toggle="tooltip" title="{{ 'Praksa je završila.' }}" class="link_object expired_gray" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
										@endif
										</div>
										
									@endforeach
								@endif
								</td>
							</tr>
						</table>	
					</div>
				</div>	
			</div>
        </div>
    </div>
</div>
@endsection
