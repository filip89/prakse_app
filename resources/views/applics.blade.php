@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Prijave</h1>
			@if(Session::has('status'))
				<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($applics) < 1)
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna neobrađena prijava.</h3>
			@else
			<div class="row">
				<div class="col-sm-9 col-xs-6"></div>
				<div class="col-sm-3 col-xs-6 little_info">
				Ukupan broj prijava: {{ $applicsNum }}<br/>
				Od toga obrađene: {{ $processedApplics }}
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Student</th>
						<th>Vrijeme prijave</th>
						<th>Godina studija</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($applics as $applic)	
					<tr>
						<td>
						{{ $applic->student->name . " " . $applic->student->last_name }}
						</td>
						<td>
						{{ $applic->created_at->format('d. m. Y. h:i:s') }}
						</td>
						<td>
						{{ Utilities::academicYear($applic->academic_year) }}
						</td>

						<td class="row_buttons">
						@if(Utilities::competitionStatus() == 2)
						{{ Form::open(array('route' => array('internships.create'), 'method' => 'GET')) }}
							{{ Form::hidden('name', $applic->student->name) }}
							{{ Form::hidden('last_name', $applic->student->last_name) }}
							{{ Form::hidden('student_id', $applic->student->id) }}
							{{ Form::hidden('applic_id', $applic->id) }}
							{{ Form::submit('Izradi praksu', ['class' => 'btn btn-primary btn-sm']) }}
						{{ Form::close() }}
						
						{{ Form::open(array('url' => '/applic/'.$applic->id.'/delete', 'method' => 'POST')) }}
							{{ Form::button('Ukloni', ['type' => 'button','class' => 'btn btn-danger btn-sm delete']) }}
							{{ csrf_field() }}
						{{ Form::close() }}
						@else
							{{ Form::button('Izradi praksu', ['class' => 'btn btn-primary btn-sm', 'disabled']) }}
							{{ Form::button('Ukloni', ['type' => 'button','class' => 'btn btn-danger btn-sm delete', 'disabled']) }}
						@endif
						</td>

					</tr>
					@endforeach
				</tbody>
				</table>
				<div class="pagination">{{ $applics->links() }}</div>
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
