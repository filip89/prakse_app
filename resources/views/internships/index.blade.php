@extends('layouts.app')

@section('content')
<style>
td, th {
	text-align: center;
	vertical-align: middle !important;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">

			@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif	

			<h1>Prijavljene prakse</h1>

			@if(count($internships) == null  && !isset($_GET['srch_term']))
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna praksa.</h3>
			@else

			<div class="search_box">
				<form class="search_form" action="{{ action('InternshipController@index') }}" method="GET">			
				    <div class="input-group">
				        {{ Form::text('srch_term', Request::get('srch_term'), ['class' => 'form-control', 'placeholder' => 'Pretraži...']) }}
					    <span class="input-group-btn">
					      	<button class="btn btn-default search-btn" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					    </span>
				    </div>			  	
				</form>
			</div>
			
			<div class="table-responsive">

				<table class="table table-striped">

					<thead>
						<tr>
							<th>Rang</th>
							<th>Prosjek preddipl.</th>
							<th>Prosjek dipl.</th>
							<th>Izvannast. akt.</th>
							<th>Ukupno</th>
							<th>Ime</th>
							<th>Prezime</th>
							<th>Akademska godina</th>
							<th>Tvrtka</th>	
							@if(count($internships) != null) <th></th> @endif					
						</tr>
					</thead>
					{{--*/ $count = '' /*--}}

					<tbody>						
					@if(count($internships) != null)
					@foreach($internships as $internship)
						
						<tr>					
							<td>{{ $count+1 }}</td>
							<td>{{ $internship->average_bacc_grade }}</td>
							<td>{{ $internship->average_master_grade }}</td>
							<td>{{ $internship->activity_points }}</td>
							<td>{{ $internship->total_points }}</td>
							<td>{{ $internship->student['name']}}</td>
							<td>{{ $internship->student['last_name']}}</td>
							<td>{{ $academicYear->academicYear($internship->academic_year) }}</td>
							<td class="centered"><a class="circle yes" data-id={{ $internship->internships_id }} data-toggle="modal" href="#myModalCompany"><i class="fa fa-plus fa-xs y" aria-hidden="true"></i></a></td>									

							<td class="row_buttons centered">
								{{ Form::open(['route' => ['internships.show', $internship->internships_id], 'method' => 'GET']) }}
									<button class="btn btn-info btn-sm">Prikaži</button>
								{{ Form::close() }}
												
								{{ Form::open(['route' => ['internships.destroy', $internship->internships_id], 'method' => 'DELETE']) }}
									<button type="button" class="btn btn-danger btn-sm delete">Ukloni</button>
								{{ Form::close() }}
							</td>
		
						</tr>
						{{--*/ $count += 1 /*--}}

					@endforeach
					@else
						<td colspan="10"><h3>Nema pronađenih rezultata</h3></td>
					@endif

					</tbody>

				</table>
			</div>

			<div class="pagination">{{ $internships->render() }}</div>
			
			@endif
		</div>
	</div>
</div>	

@if(count($internships) != null)
<!--Modal -->
<div class="modal fade" id="myModalCompany">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      <h4 class="modal-title">Odaberite tvrtku</h4>
	    </div>
	    <div class="modal-body">
	    	<h5 style="text-align: center; color: #d9534f;">*Odabirom tvrtke praksa postaje konačna</h5>
		<form role="form" method="POST" action="{{ action('InternshipController@addCompany') }}">
	        {{ csrf_field() }}
                <input type="hidden" id="internship_id" name="internship_id" value="" />
		    	<div class="table-responsive">
				<table class="table table-striped">
			            <thead>
					<tr>
						<th>Naziv tvrtke</th>
						<th>Sjedište</th>
						<th>Broj slobodnih mjesta</th>
						<th></th>				
					</tr>
				    </thead>

				<tbody>
					@foreach($companies as $elem)
						@if($elem->spotsAvailable() > 0)

							<tr>
						    <td>
						    <div class="radiotext">
							<label for='company'>{{ $elem->name }}</label>
						    </div>
						    </td>

						    <td>
						    <div class="radiotext">
							<label for='company'>{{ $elem->residence }}</label>
						    </div>
						    </td>

						    <td>
						    <div class="radiotext">
							<label for='company'>{{ $elem->spotsAvailable() }}</label>
						    </div>
						    </td>

						    <td>
						<div class="radio">
						    <label><input style="width:20px; height:20px;" type="radio" id='company_id' name="company_id" value="{{ $elem->id }}"></label>						                    
						</div>
						    </td>
						</tr>
						@endif
					@endforeach
				</tbody>
		      		</table>
				
                        <button type="submit" class="btn btn-primary action_buttons"><i class="fa fa-btn fa-sign-in"></i> Spremi</button>
                   
		      	</div>      	
	        </form>
	    </div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@endsection

@section('modal_body_content')
	Ukloniti praksu
@endsection



