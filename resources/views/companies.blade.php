@extends('layouts.app')

@section('style')
#add_company {
	font-size: 20px;
	margin-bottom: 10px;
}
button{
	width: 100%;
}
th {
	font-size: 16px;
}
table, th {
	text-align: center;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
				<a href="{{ url('/company/create') }}">
					<button id="add_company" class="btn btn-primary btn-sm">Dodaj tvrtku</button>
				</a>
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Tvrtka</th>
							<th>Sjedište</th>
							<th>Datum stvaranja</th>
							<th></th>
							<th></th>
						</tr>
						@foreach($companies as $company)	
						<tr>
							<td>
							{{$company->name}}
							</td>
							<td>
							{{$company->residence}}
							</td>
							<td>
							{{$company->created_at->format('d-m-Y')}}
							</td>
							<td>
								<a href="{{ url('/company/profile/' . $company->id) }}">
									<button class="btn btn-info btn-sm">Profil</button>
								</a>
							</td>
							
							<td>
								<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
								{{ csrf_field() }}
								<button style="font-size:12px" type="button" class="btn btn-danger delete" >Ukloni</button>
								</form>
							</td>
						</tr>
						@endforeach
					
					</table>
				</div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
	$(document).on("click", ".delete", function(){
		if(confirm('Želite obrisati prijavu?')){
		$(this).closest('form').submit();
		}	
	});
</script>
@endsection
