@extends('layouts.app')

@section('style')
th {
	font-size: 16px;
}
table, th {
	text-align: center;
}
.fa-check-circle {
	color: darkgreen;
	font-size: 16px;
}
.hasInternship {
	background-color: lightgreen;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th></th>
							<th>Student</th>
							<th>Željene tvrtke</th>
							<th>Datum stvaranja prijave</th>
						</tr>
						@foreach($applics as $applic)	
						@if(isset($applic->student->internship))
						<tr class="hasInternship">
							<td>
								<i class="fa fa-check-circle" aria-hidden="true"></i>
							</td>
							<td>							
							{{$applic->student->name . " " . $applic->student->last_name}}
							</td>
							<td>
							{{ $applic->desired_company }}
							</td>
							<td>
							{{$applic->created_at->format('d-m-Y')}}
							</td>
						</tr>
						@else
							<tr>
							<td>
							</td>
							<td>							
							{{$applic->student->name . " " . $applic->student->last_name}}
							</td>
							<td>
							{{ $applic->desired_company }}
							</td>
							<td>
							{{$applic->created_at->format('d-m-Y')}}
							</td>
						</tr>
						@endif
						@endforeach
					
					</table>
				</div>
        </div>
    </div>
</div>
@endsection