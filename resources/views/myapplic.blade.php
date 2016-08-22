@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
			
			@if(count(Auth::user()->applic) > 0)
			<p>Izradili ste prijavu.</p>
			<a href="/apply"><button class="btn btn-info btn-sm">Uredi</button></a>
			<form action="{{ url('applic/'. Auth::user()->id . '/delete') }}" method="POST">
								{{ csrf_field() }}
				<button class="btn btn-danger btn-sm">Ukloni</button>
			</form>
			@else
			<p>Niste još izradili prijavu.</p>
			<a href="/apply"><button class="btn btn-info btn-sm">Prijavi se</button></a>
			@endif
        </div>
    </div>
</div>
@endsection