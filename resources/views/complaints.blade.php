@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Pritužbe</h1>
			@if(Session::has('status'))
				<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($complaints) < 1)
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna pritužba.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Student</th>
						<th>Vrijeme pritužbe</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($complaints as $complaint)	
					@if($complaint->status == 0)
					<tr style="background-color:#ff8c66">
					@else
					<tr style="background-color:#00ff55">
					@endif
						<td>
						{{ $complaint->student->name . " " . $complaint->student->last_name }}
						</td>
						<td>
						{{ $complaint->created_at->format('d. m. Y. h:i:s') }}
						</td>
						<td>
						@if($complaint->status == 0)
							Neriješena
						@else
							Riješena
						@endif
						</td>

						<td class="row_buttons">
							<a type="button" class="btn btn-info btn-sm" href="{{ url('/complaint/' . $complaint->id) }}">Prikaži</a>
							<form action="{{ url('/complaint/delete/' . $complaint->id) }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete" >Ukloni</button>
							</form>
						</td>

					</tr>
					@endforeach
				</tbody>
				</table>
				<div class="pagination">{{ $complaints->links() }}</div>
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
