@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Popis prijašnjih tvrtki</h1>
        	@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			@endif
			@if(count($companies) == 0)
				<h3 style="text-align:center;color:gray;">Nema tvrtki iz prošlih natječaja.</h3>
			@else
				<div class="table-responsive">
					<table class="table table-striped">
					<thead>
						<tr>
							<th>Tvrtka</th>
							<th>Sjedište</th>
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
							{{ $company->created_at->format('d-m-Y') }}
							</td>
							<td class="row_buttons">
								<form action="{{ url('/company/reinstate/' . $company->id) }}" method="POST">
								{{ csrf_field() }}
								<button class="btn btn-primary btn-sm" >Dodaj</button>
								</form>
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
