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
			@if(count($allCompanies) == 0)
				<h3 style="text-align:center;color:gray;">Nema potvrđenih tvrtki.</h3>
			@endif
			@if(Auth::user()->isAdmin())
			<a id="add_button" class="btn btn-primary" type="button" href="{{ url('/company/create') }}"><i class="fa fa-btn fa-user-plus" aria-hidden="true"></i>Dodaj tvrtku</a>
			@endif
			@if(count($allCompanies) > 0)
		<div class="row">
			<div class="col-sm-3 col-xs-6 filter" style="margin-bottom:20px;">
				<form method="get" action="{{ url('/company') }}">
						<select class="form-control"  name="filter" onchange="this.form.submit()">
							@if(!isset($_GET['filter']) || $_GET['filter'] == 'all')
							<option value="all" selected>Sve</option>
							@else
							<option value="all">Sve</option>
							@endif
							@if(isset($_GET['filter']) && $_GET['filter'] == 'confirmed')
							<option value="confirmed" selected>Aktualne</option>
							@else
							<option value="confirmed">Aktualne</option>
							@endif
							@if(isset($_GET['filter']) && $_GET['filter'] == 'unconfirmed')
							<option value="unconfirmed" selected>Neaktualne</option>
							@else
							<option value="unconfirmed">Neaktualne</option>
							@endif
						</select>
				</form>
			</div>
			<div class="col-sm-6 col-xs-0"></div>
			<div class="col-sm-3 col-xs-6 little_info">
			Ukupan broj tvrtki: {{ count($allCompanies) }}<br/>
			Od toga aktualne: {{ count($confirmedCompanies) }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
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
									@if($company->status == 0)
									<form action="{{ url('/company/reinstate/' . $company->id) }}" method="POST">
									{{ csrf_field() }}
									<button class="btn btn-primary btn-sm" >Potvrdi</button>
									</form>
									@endif
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
					@if(isset($_GET['filter']))
					{{ $companies->appends(['filter' => $_GET['filter']])->links() }}
					@else
					{{ $companies->links() }}
					@endif
				</div>
			@endif
        </div>
		</div>
    </div>
</div>
@endsection

