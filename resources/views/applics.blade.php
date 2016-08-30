@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	@if(Session::has('status'))
			<div class="alert alert-warning {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Student</th>
						<th>Vrijeme prijave</th>
						<th></th>
						<th></th>
					</tr>
					
					@foreach($applics as $applic)	
					<tr>
						<td>
						{{ $applic->student->name . " " . $applic->student->last_name }}
						</td>
						<td>
						{{ $applic->updated_at }}
						</td>

						<td>
						{{ Form::open(array('route' => array('internships.create', $applic->student->id), 'method' => 'GET')) }}
							{{ Form::hidden('name', $applic->student->name) }}
							{{ Form::hidden('last_name', $applic->student->last_name) }}
							{{ Form::hidden('student_id', $applic->student->id) }}
							{{ Form::submit('Analiza', ['class' => 'btn btn-primary']) }}
						{{ Form::close() }}
						</td>

						<td>
						{{ Form::open(array('url' => '/applic/'.$applic->student->id.'/delete', 'method' => 'POST')) }}
							{{ Form::submit('Ukloni', ['class' => 'btn btn-danger']) }}
							{{ csrf_field() }}
						{{ Form::close() }}
						</td>

					</tr>
					@endforeach
					
				</table>
			</div>
        </div>
    </div>
</div>
@endsection
