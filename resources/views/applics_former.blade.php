@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
			<h1>Povijest prijava</h1>
			@if(Session::has('status'))
				<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
			
			@endif
			@if(count($competitions) == 0)
				<h3 style="text-align:center;color:gray;margin-bottom:40px;">Nema završenih natječaja.</h3>
			@else
		<div class="row">
			<div class="col-sm-3 col-xs-6 filter" style="margin-bottom:20px;">
			<b>Natječaj: </b>
				<form method="get" action="{{ url('/applics/former') }}">
						<select class="form-control"  name="competition" onchange="this.form.submit()">
							@foreach($competitions as $competition)
							@if(isset($_GET['competition']) && $_GET['competition'] == $competition->id)
							<option selected value="{{ $competition->id }}">{{ isset($competition->name) ? $competition->name . ', ' : ''}} {{ $competition->created_at->format('d. m. Y.') }}</option>
							@else
							<option value="{{ $competition->id }}">{{ isset($competition->name) ? $competition->name . ', ' : ''}} {{ $competition->created_at->format('d. m. Y.') }}</option>
							@endif
							@endforeach

						</select>
				</form>
			</div>
			<div class="col-sm-9 col-xs-6"></div>
		</div>
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Student</th>
						<th>Vrijeme prijave</th>
						<th>Godina studija</th>
						<th>Praksa</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($applics as $applic)	
					<tr>
						<td>
						<a  class="link_object" href="{{ url('/user/' . $applic->student_id) }}">{{ $applic->student->name . ' ' . $applic->student->last_name }}</a>
						</td>
						<td>
						{{ $applic->created_at->format('d. m. Y. h:i:s') }}
						</td>
						<td>
						{{ Utilities::academicYear($applic->academic_year) }}
						</td>
						<td>
						@if($applic->confirmedInternship())
						<a class="link_object" href="{{ url('/internships/' . $applic->confirmedInternship()->id)}}">{{ $applic->confirmedInternship()->company->name . ' (' . $applic->competition->created_at->format('Y.') . ')' }}</a>
						@else
							Nije dobio/la
						@endif
						</td>

						<td class="row_buttons">
							<a type="button" class="btn btn-info btn-sm" href="{{ url('/applic/' . $applic->id) }}">Prikaži</a>
						{{ Form::open(array('url' => '/applic/delete/'.$applic->id, 'method' => 'POST')) }}
							{{ Form::button('Ukloni', ['type' => 'button','class' => 'btn btn-danger btn-sm delete', 'data-info' => $applic->student_full_name ]) }}
							{{ csrf_field() }}
						{{ Form::close() }}	
						</td>

					</tr>
					@endforeach
				</tbody>
				</table>
				<div class="pagination">
				@if(isset($_GET['competition']))
					{{ $applics->appends(['competition' => $_GET['competition']])->links() }}
				@else
					{{ $applics->links() }}
				@endif
			@endif
				
				</div>
			</div>
        </div>
    </div>
</div>
@endsection

	@section('modal_body_content')
		Ukoliko uklonite prijavu, automatski se briše i praksa izrađena od te prijave.</br>
		Ukloniti prijavu od studenta/ice
	@endsection
