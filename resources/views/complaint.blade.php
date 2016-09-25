@extends('layouts.app')

@section('style')
	form {
		display: inline;
	}
	.table_section {
		text-decoration: underline;
		font-size: 16px;
		padding: 10px;
		background-color: #8080ff;
		color: white;
	}
	table:nth-of-type(1)  {
		margin-top: 20px;
	}
	.action_buttons {
		display: table;
		margin: auto;
	}
	.activity_info div:last-child{
		word-wrap: break-word;
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
			<table class="table table-striped table-bordered">
				<tr><th colspan="2" class="table_section">Detalji pritužbe</th></tr>
				<tr><th>Ime:</th><td>{{ $student->name }}</td></tr>
				<tr><th>Prezime</th><td>{{ $student->last_name }}</td></tr>
				<tr><th>E-mail</th><td>{{ $student->email }}</td></tr>
				<tr><th>Posljednja prijava: </th>
					<td>
					@if($student->lastApplic())
						<a href="{{ url('/applic/' . $student->lastApplic()->id) }}">{{ $student->lastApplic()->id }}</a>
					@else
						Nije imao/la
					@endif
					</td>
				</tr>
				<tr><th>Posljednja praksa</th>
					<td>
					@if($student->lastApplic())
						<a href="{{ url('/internships/' . $student->lastInternship()->id) }}">{{ $student->lastInternship()->id }}</a>
					@else
						Nije imao/la
					@endif
					</td>
				</tr>
				<tr><th colspan="2">Pritužba:</th></tr>
				<tr><td colspan="2">{{ $complaint->content }}</td></tr>
			</table>
			<div class="action_buttons">
				<form action="{{ url('/complaint/status/' . $complaint->id) }}" method="POST">
					{{ csrf_field() }}
					@if($complaint->status == 0)
					<button class="btn btn-success btn-bg" >Označi kao riješeno</button>
					@else
					<button class="btn btn-warning btn-bg" >Označi kao neriješeno</button>
					@endif
				</form>
				<form action="{{ url('/complaint/delete/' . $complaint->id) }}" method="POST">
					{{ csrf_field() }}
					<button type="button" class="btn btn-danger btn-sm delete" >Ukloni</button>
				</form>
			</div>
        </div>
    </div>
</div>
@endsection