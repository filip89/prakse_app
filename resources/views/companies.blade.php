@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				<table>
					<tr>
						<th>Tvrtka</th>
						<th>Datum stvaranja</th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<td>
							<a href="/company/create">
								<button class="btn btn-info btn-sm">Dodaj</button>
							</a>
						</td>
					</tr>
					@foreach($companies as $company)	
					<tr>
						<td>
						{{$company->name}}
						</td>
						<td>
						{{$company->created_at}}
						</td>
						<td>
							<a href="/company/profile/{{ $company->id }}">
								<button class="btn btn-info btn-sm">Profil</button>
							</a>
						</td>
						<td>
							<a href="/company/delete/{{ $company->id }}">
								<button class="btn btn-danger btn-sm">Ukloni</button>
							</a>
						</td>
					</tr>
					@endforeach
					
				</table>
        </div>
    </div>
</div>
@endsection