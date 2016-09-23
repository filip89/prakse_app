@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Popis tvrtki</h1>
        	@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($companies) == 0)
				<h3 style="text-align:center;color:gray;">Nema potvrđenih tvrtki.</h3>
			@endif
			@if(Auth::user()->isAdmin())
			<a id="add_button" class="btn btn-primary" type="button" href="{{ url('/company/create') }}"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj tvrtku</a>
			@endif
			@if(count($companies) > 0)	
				<div class="table-responsive">
					<table class="table table-striped">
					<thead>
						<tr>
							<th>Tvrtka</th>
							<th>Sjedište</th>
							<th>Broj mjesta </th>
							<th>Broj slobodnih mjesta </th>
							<th>Datum stvaranja</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($companies as $company)	
						<tr>
							<td>
							<a class="link_object" href="{{ url('/company/profile/' . $company->id) }}">{{ $company->name }}</a>
							</td>
							<td>
								{{ $company->residence }}
							</td>
							<td>
								{{ $company->spots }}
							</td>
							<td>
								{{ $company->spotsAvailable() }}
							</td>
							<td>
							{{ $company->created_at->format('d. m. Y.') }}
							</td>
							<td class="row_buttons">
								<a type="button" class="btn btn-info btn-sm" href="{{ url('/company/profile/' . $company->id) }}">Profil</a>
								@if(Auth::user()->isAdmin())
								<a type="button" class="btn btn-warning btn-sm" href="{{ url('/company/edit/' . $company->id) }}">Uredi</a>
								<form action="{{ url('/company/delete/' . $company->id) }}" method="POST">
								{{ csrf_field() }}
								<button type="button" class="btn btn-danger btn-sm delete" >Ukloni</button>
								</form>
								@endif
							</td>
						</tr>
						@endforeach
					</thead>
					</table>
					<div class="pagination">{{ $companies->links() }}</div>
				</div>
			@endif
        </div>
    </div>
</div>
@endsection

