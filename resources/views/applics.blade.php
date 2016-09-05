@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Prijave</h1>
			@if(count($applics) < 1)
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna prijava.</h3>
			@else
        	@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Student</th>
						<th>Vrijeme prijave</th>
						<th>Godina studija</th>
						<th></th>
					</tr>
					
					@foreach($applics as $applic)	
					<tr>
						<td>
						{{ $applic->student->name . " " . $applic->student->last_name }}
						</td>
						<td>
						{{ $applic->created_at->format('d-m-Y h:i:s') }}
						</td>
						<td>
						{{ Utilities::academicYear($applic->academic_year) }}
						</td>

						<td class="row_buttons">
						{{ Form::open(array('route' => array('internships.create', $applic->student->id), 'method' => 'GET')) }}
							{{ Form::hidden('name', $applic->student->name) }}
							{{ Form::hidden('last_name', $applic->student->last_name) }}
							{{ Form::hidden('student_id', $applic->student->id) }}
							{{ Form::submit('Prikaži', ['class' => 'btn btn-info btn-sm']) }}
						{{ Form::close() }}
						
						{{ Form::open(array('url' => '/applic/'.$applic->student->id.'/delete', 'method' => 'POST')) }}
							{{ Form::submit('Ukloni', ['class' => 'btn btn-danger btn-sm delete']) }}
							{{ csrf_field() }}
						{{ Form::close() }}
						</td>

					</tr>
					@endforeach
					
				</table>
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
