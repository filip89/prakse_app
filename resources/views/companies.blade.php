@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
			<h1>Popis tvrtki</h1>
        	@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
				<a id="add_button" class="btn btn-primary" type="button" href="{{ url('/company/create') }}">Dodaj tvrtku</a>
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Tvrtka</th>
							<th>Sjedište</th>
							<th>Datum stvaranja</th>
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
							<td class="row_buttons">
								<a type="button" class="btn btn-info btn-sm" href="{{ url('/company/profile/' . $company->id) }}">Profil</a>
								<a type="button" class="btn btn-warning btn-sm" href="{{ url('/company/edit/' . $company->id) }}">Uredi</a>
								<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete" >Ukloni</button>
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
