@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr>
						<th>Student</th>
						<th>Datum prijave</th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<td></td>
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
							<a href="/apply/{{ $applic->student->id }}">
								<button class="btn btn-default btn-sm">Analiza</button>
							</a>
						</td>
						<td>
							<form action="{{ url('applic/'. $applic->student->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-danger btn-sm">Ukloni</button>
							</form>
						</td>
					</tr>
					@endforeach
					
				</table>
        </div>
    </div>
</div>
@endsection