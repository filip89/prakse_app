@extends('layouts.app')

@section('style')
#add_mentor {
	width: 100%;
	padding: 2px;
	font-size: 12px;
	margin-top: 5px;
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
				<div class="panel-heading"><i class="fa fa-btn fa-briefcase" aria-hidden="true"></i>Tvrtka</div>
				<div class="panel-body">
					<div class="action_buttons">
					@if(Auth::user()->isAdmin() || (Auth::user()->role == 'intern_mentor' && (isset(Auth::user()->profile->company) && Auth::user()->profile->company->id == $company->id)))
						<a href="{{ url('/company/edit/' . $company->id) }}"><button class="btn btn-warning" >Uredi</button></a>
					@endif
					@if(Auth::user()->isAdmin())
						<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
							{{ csrf_field() }}
							<button type="button" class="btn btn-danger delete" >Ukloni</button>
						</form>
					@endif
					</div>
					<div class="table-responsive">
						<table class="table profile_table">
							<tr><th>Naziv tvrtke:</th><td>{{ $company->name }}</td></tr>
							<tr><th>Sjedište:</th><td>{{ $company->residence }}</td></tr>
							<tr><th>E-mail:</th><td>{{ $company->email }}</td></tr>
							<tr><th>Telefon:</th><td>{{ $company->phone }}</td></tr>
							@if(Auth::user()->isAdmin() || (Auth::user()->role == 'intern_mentor' && (isset(Auth::user()->profile->company) && Auth::user()->profile->company->id == $company->id)))
							@if($company->status == 1)
							<tr><th>Mjesta za praksu:</th><td>{{ $company->spots }}</td></tr>
							@endif
							@if(Utilities::competitionStatus() != 0)
							<tr><th>Preostalo mjesta:</th><td>{{ $company->spotsAvailable() }}</td></tr>
							@endif
							<tr><th>Mentori:</th>
								<td>
								@foreach($company->intern_mentors as $mentor)
								<div class="user_item">
									<a class="link_object" href="{{ url('/user/' . $mentor->user->id) }}">{{$mentor->user->name . ' ' . $mentor->user->last_name}}</a><br/>
								</div>
								@endforeach
								@if(Auth::user()->isAdmin())
								<div class="user_item">
									<a type="button"  id="add_mentor" class="btn btn-primary" href="{{ url('/user/add/internmentor/' . $company->id) }}"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj mentora iz tvrtke</a><br/>
								</div>
								@endif
								</td>
							</tr>
							@if(Auth::user()->role != 'student')
							<tr><td style="text:align:center" colspan="2"><a type="button" class="btn btn-bg btn-default" href="{{ url('/company_internships/' . $company->id) }}"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Povijest praksi</a></td></tr>
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
										<i><small>Nema praktikante s tekućeg natječaja</small></i>
									@endif
								@elseif(Utilities::competitionStatus() == 0)
									<i><small>Nema tekućeg natječaja</small></i>
								@elseif(Utilities::competitionStatus() == 1)
									<i><small>Natječaj je još otvoren</small></i>
								@endif
								</td>
								<td>Nedavne prakse:</br>
								@if(count($recentInterns) == 0)
									<i><small>Nema praktikante u zadnjih 6 mjeseci</small></i>
								@else
								
									@foreach($recentInterns as $internship)
										
										<div class="user_item">
										@if(strtotime($internship->start_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa počinje za ' . (strtotime($internship->start_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@elseif(strtotime($internship->end_date) > strtotime(date('d-m-Y')))
											<a data-toggle="tooltip" title="{{ 'Praksa traje još ' . (strtotime($internship->end_date) - strtotime(date('d-m-Y')))/86400 . ' dana.' }}" class="link_object current_green" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }} <i class="fa fa-btn fa-clock-o" aria-hidden="true"></i></a>
										@else
											<a data-toggle="tooltip" title="{{ 'Praksa je završila ' . date_create($internship->end_date)->format('d. m. Y.') }}" class="link_object expired_gray" href="{{url('/internships/' . $internship->id)}}">{{ $internship->student->name . " " . $internship->student->last_name }}</a>
										@endif
										</div>
										
									@endforeach
								@endif
								</td>
							</tr>
							@endif
							@endif
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
