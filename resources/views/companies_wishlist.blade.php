@extends('layouts.app')

@section('style')
.hasInternship .fa-check-circle {
	color: darkgreen;
	font-size: 16px;
}
.hasInternship {
	background-color: #99ff99;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Popis željenih tvrtki</h1>
			@if(count($applics) < 1)
				<h3 style="text-align:center;color:gray;">Ne postoji niti jedna prijava sa željenim tvrtkama.</h3>
			@else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Željene tvrtke</th>
						<th>Student</th>	
						<th>Datum prijave</th>
					</tr>
				</thead>
				<tbody>
						@foreach($applics as $applic)	
						@if($applic->student->hasCompany() == 2)
						<tr class="hasInternship">
							<td>
								<b>{{ $applic->desired_company }}</b>
							</td>
							<td>							
								{{$applic->student->name . " " . $applic->student->last_name}} <i class="fa fa-check-circle" aria-hidden="true"></i>
							</td>
							<td>
								{{$applic->created_at->format('d-m-Y')}}
							</td>
						</tr>
						@else
							<tr>
							<td>
								<b>{{ $applic->desired_company }}</b>
							</td>
							<td>							
								{{$applic->student->name . " " . $applic->student->last_name}}
							</td>
							<td>
								{{$applic->created_at->format('d-m-Y')}}
							</td>
						</tr>
						@endif
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