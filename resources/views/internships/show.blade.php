@extends('layouts.app')

@section('style')
a {
	display: block;
}
th {
	font-size: 16px;
}
table, th {
	text-align: center;
}
h1 {
	text-align: center;
}
.action_buttons {
	display: table;
	margin: auto;
}
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
.optional {
	text-decoration: none;
}
table:nth-of-type(1)  {
	margin-top: 20px;
}
.comment_box {
	width: 40%;
}
.doc_info {
	font-size: 13px;
}
.doc_title {
	text-decoration: underline;
}
.comment_text {
	position: relative;
}
.comment_text:hover {
	background
}
.comment_button {
	display: none;
	position: absolute;
	top: 50%; left: 50%;
    transform: translate(-50%,-50%);
	z-index: 2;
}
@endsection

@section('content')
<style>
.star-rating{
  font-size:0;
  white-space:nowrap;
  display:inline-block;
  width:200px;
  height:40px;
  overflow:hidden;
  position:relative;
  background:
      url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
  background-size: contain;}
  .star{
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 20%;
    z-index: 1;
    background: 
        url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');  
    background-size: contain;
  }
  .star-input{ 
    -moz-appearance:none;
    -webkit-appearance:none;
    opacity: 0;
    display:inline-block;
    width: 20%;
    height: 100%; 
    margin:0;
    padding:0;
    z-index: 2;
    position: relative;
  }
.star-input:hover + .star{
	opacity:1;
}
.star-input:checked + .star{
    opacity:1;      
}
.star ~ .star{
    width: 40%;
}
.star ~ .star ~ .star{
    width: 60%;
}
.star ~ .star ~ .star ~ .star{
    width: 80%;
}
.star ~ .star ~ .star ~ .star ~ .star{
    width: 100%;
}

</style>

<div class="col-md-6 col-md-offset-3">

		@if(Session::has('status'))
			<div class="alert {{ Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif	

	@foreach($internships as $internship)

		@if(isset($paginate) == 1)<div class="pagination">{{ $internships->render() }}</div>@endif
		@if($internship->student->id == Auth::user()->id)
			<a type="button" style="float:right;margin-bottom:20px" class="btn btn-bg btn-default" href="/user_internships"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Prijašnje prakse</a>
		@endif
		<h1 style="clear:both;">{{ $internship->student['name'].' '.$internship->student['last_name'] }}@if($internship->company_id != 0){{ ' - '.$internship->company['name'] }}@endif</h1>
		
		@if(Auth::user()->isadmin())
		<div class="action_buttons">
			<a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Uredi</a>
			
			{{ Form::open(['route' => ['internships.destroy', $internship->id], 'method' => 'DELETE']) }}
				<button type ="button" class="btn btn-danger btn-sm delete">Ukloni</button>
			{{ Form::close() }}
		</div>
		@endif

		<table class="table table-striped table-bordered">
				<tr><th colspan="2" class="table_section">Osobni podaci</th></tr>
				<tr><th>Ime:</th><td>{{ $internship->student['name'] }}</td></tr>
				<tr><th>Prezime</th><td>{{ $internship->student['last_name'] }}</td></tr>
				<tr><th>E-mail</th><td>{{ $internship->student['email'] }}</td></tr>
				
				<tr><th colspan="2" class="table_section">Akademski podaci</th></tr>
				<tr><th>Prosjek na preddiplomskom:</th><td>{{ $internship->average_bacc_grade }}</td></tr>
				<tr><th>Prosjek na diplomskom:</th><td>{{ $internship->average_master_grade }}</td></tr>
				<tr><th>Izvannastavne aktivnosti:</th><td>{{ $internship->activity_points }}</td></tr>
				<tr><th>Ukupno ostvareni bodovi:</th><td>{{ $internship->total_points }}</td></tr>

				<tr><th colspan="2" class="table_section">Praksa</th></tr>
				<tr><th>Tvrtka:</th><td><a href="{{ action('CompanyController@profile', $internship->company['id'] ) }}">{{ $internship->company['name'] }}</a></td></tr>
				<tr><th>Mentor iz tvrtke:</th><td><a href="{{ action('UserController@viewProfile', $internship->intern_mentor['id']) }}">{{ $internship->intern_mentor['name'].' '.$internship->intern_mentor['last_name'] }}</a></td></tr>
				<tr><th>Mentor nastavnik:</th><td><a href="{{ action('UserController@viewProfile', $internship->college_mentor['id']) }}">{{ $internship->college_mentor['name'].' '.$internship->college_mentor['last_name'] }}</a></td></tr>
				<tr><th>Trajanje prakse:</th><td>{{ $internship->duration }}</td></tr>
				<tr><th>Datum početka prakse:</th><td>
					@if($internship->start_date == null)
	                    {{ $internship->start_date }}
	                @else
	                    {{ date('d M, Y', strtotime($internship->start_date)) }}
	                @endif
	            </td></tr>
				<tr><th>Datum završetka prakse:</th><td>
					@if($internship->end_date == null)
	                    {{ $internship->end_date }}
	                @else
	                    {{ date('d M, Y', strtotime($internship->end_date)) }}
	                @endif
	            </td></tr>
				<tr><th class="centered">Studentova ocjena prakse:</th><td>
					<span class="star-rating" @if(Auth::user()->id != $internship->student_id && Auth::user()->isAdmin() == false || new DateTime('now') < new DateTime($internship->end_date)) style="pointer-events: none;" @endif>
						<input type="radio" name="rating" class="star-input" value="1"><i class="star" @if($internship->rating_by_student == 1) style="width: 20%; opacity: 1;" @endif></i>
						<input type="radio" name="rating" class="star-input" value="2"><i class="star" @if($internship->rating_by_student == 2) style="width: 40%; opacity: 1;" @endif></i>
						<input type="radio" name="rating" class="star-input" value="3"><i class="star" @if($internship->rating_by_student == 3) style="width: 60%; opacity: 1;" @endif></i>
						<input type="radio" name="rating" class="star-input" value="4"><i class="star" @if($internship->rating_by_student == 4) style="width: 80%; opacity: 1;" @endif></i>
						<input type="radio" name="rating" class="star-input" value="5"><i class="star" @if($internship->rating_by_student == 5) style="width: 100%; opacity: 1;" @endif></i>
						<input type="hidden" name="student_id" id="student_id" value="{{ $internship->student_id }}">
					</span>

				</td></tr>

				<tr><th colspan="2" class="table_section">Komentari</th></tr>
				<tr><th class="centered">Komentar studenta:</th><td class="comment_box">
				@if(Auth::user()->role == 'student' && $internship->student_comment == null)
					<button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					@include('layouts.comment_create')
				@elseif($internship->student_comment != null)
					<div class="comment_text"><span class="test">{{ $internship->student_comment }}</span>
					@if(Auth::user()->role == 'student')
						<div class="comment_button"><button class="btn btn-warning" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></div>
						@include('layouts.comment_edit')				
					@endif
					</div>
				@endif
				</td></tr>

				<tr><th class="centered">Komentar mentora nastavnika:</th><td class="comment_box">
				@if(Auth::user()->role == 'college_mentor' && $internship->college_mentor_comment == null)
					<button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					@include('layouts.comment_create')
				@elseif($internship->college_mentor_comment != null)
					<div class="comment_text"><span class="test">{{ $internship->college_mentor_comment }}</span>
					@if(Auth::user()->role == 'college_mentor')
						<div class="comment_button"><button class="btn btn-warning" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></div>
						@include('layouts.comment_edit')
					@endif
					</div>
				@endif
				</td></tr>

				<tr><th class="centered">Komentar mentora iz tvrtke:</th><td class="comment_box">
				@if(Auth::user()->role == 'intern_mentor' && $internship->intern_mentor_comment == null)
					<button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					@include('layouts.comment_create')
				@elseif($internship->intern_mentor_comment != null)
					<div class="comment_text"><span class="test">{{ $internship->intern_mentor_comment }}</span>
					@if(Auth::user()->role == 'intern_mentor')
						<div class="comment_button"><button class="btn btn-warning" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></div>
						@include('layouts.comment_edit')
					@endif
					</div>
				@endif
				</td></tr>

				@if(Auth::user()->id === $internship->college_mentor_id && Auth::user()->role == 'college_mentor' || Auth::user()->role == 'intern_mentor' || Auth::user()->isAdmin()) 
					<tr><th colspan="2" class="table_section optional"><span class="doc_title">Dokumenti</span><br><span class="doc_info">(Za generiranje dokumenata potrebno je studentu dodijeliti tvrtku, mentora nastavnika te odrediti trajanje prakse)</span></th></tr> 
				@endif

				@if(Auth::user()->id === $internship->college_mentor_id && Auth::user()->role == 'college_mentor' || Auth::user()->isAdmin())	
					<tr><th>Uputnica za studentsku stručnu praksu:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="1">
							<button type="submit" class="btn btn-success fa-sm" 
							@if($internship->company_id == null || $internship->duration == null || $internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
						</form>
					</td></tr>
					<tr><th>Potvrda o obavljenoj edukaciji:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="3">
							<button type="submit" class="btn btn-success fa-sm" 
							@if($internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
						</form>
					</td></tr>
				@endif

				@if(Auth::user()->role == 'intern_mentor' || Auth::user()->isAdmin())
					<tr><th>Potvrda o obavljenoj praksi:</th><td class="comment_box">
						<form action="{{ url('/internships/document') }}" method="GET">
							<input type="hidden" name="internship_id" value="{{ $internship->id }}">
							<input type="hidden" name="doc_id" value="2">
							<button type="submit" class="btn btn-success fa-sm"
							@if($internship->company_id == null || $internship->duration == null || $internship->college_mentor_id == null) {{ 'disabled' }} @endif
							><i class="fa fa-file-pdf-o fa-" aria-hidden="true"></i></button>
						</form>
					</td></tr>
				@endif

				@if(Auth::user()->role == 'student')
					<tr><th colspan="2" class="table_section optional"><span class="doc_title">Izvještaj</span><br><span class="doc_info">(Za izradu izvještaja potrebno je odraditi praksu)</span></th></tr> 
					<tr><th>Izvještaj o obavljenoj praksi:</th><td class="comment_box">
						<a class="btn btn-success fa-sm" href="{{ url('/internships/createReport') }}" 
						@if(new DateTime('now') < new DateTime($internship->end_date) || $internship->status != 0 || $internship->confirmation_student == 0) {{ 'disabled' }} @endif
						><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td></tr>
				@endif
			</table>
		
	@endforeach

	<div class="action_buttons"><a type="button" class="btn btn-primary" href="{{ URL::previous() }}">Povratak</a></div><br>

</div>

@endsection

@section('modal_body_content')
	Ukloniti praksu
@endsection

