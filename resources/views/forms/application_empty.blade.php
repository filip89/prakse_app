@extends('layouts.app')

@section('style')
textarea {
	resize: vertical;
	max-height: 200px;
}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
		@if(Session::has('status'))
			<div class="alert {{Session::get('alert_type') }} fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ Session::get('status') }}
			</div>
		@endif
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Prijava prakse</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/apply') }}">
                        {{ csrf_field() }}
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"><span class="req_field">* </span>Ime:</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" disabled/>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label"><span class="req_field">* </span>Prezime:</label>

                            <div class="col-md-8">
                                <input type="txt" class="form-control" name="last_name" value="{{ $user->last_name }}" disabled/>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><span class="req_field">* </span>E-Mail adresa:</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" required/>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_town') ? ' has-error' : '' }}">
                            <label for="residence_town" class="col-md-4 control-label"><span class="req_field">* </span>Mjesto prebivališta:</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="residence_town" required/>

                                @if ($errors->has('residence_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('residence_town') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence_county') ? ' has-error' : '' }}">
                            <label for="residence_county" class="col-md-4 control-label"><span class="req_field">* </span>Županija prebivališta:</label>
							
                            <div class="col-md-8">
							
							<select class="form-control" name="residence_county" required>
								<option selected disabled hidden style='display: none'></option>
                                @foreach(Utilities::county() as $i => $county)
									@if(old('residence_county') == $i)
									<option value="{{$i}}" selected>{{ $county }}</option>
									@else
									<option value="{{$i}}">{{ $county }}</option>
									@endif
								@endforeach
							</select>

                                @if ($errors->has('residence_county'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('residence_county') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('academic_year') ? ' has-error' : '' }}">
                            <label for="academic_year" class="col-md-4 control-label"><span class="req_field">* </span>Godina studija:</label>

                            <div class="col-md-8">
								<select class="form-control" name="academic_year" required/>
									<option selected disabled hidden style='display: none'></option>
									<option value="1">1. godina prediplomskog</option>
									<option value="2">2. godina prediplomskog</option>
									<option value="3">3. godina prediplomskog</option>
									<option value="4">1. godina diplomskog</option>
									<option value="5">2. godina diplomskog</option>
								</select>

                                @if ($errors->has('academic_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('academic_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('course') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"><span class="req_field">* </span>Smjer:</label>

                            <div class="col-md-8">
								<select class="form-control" name="course" required/>
									<option selected disabled hidden style='display: none'></option>
									<option value="1">Financijski menadžment</option>
									<option value="2">Marketing</option>
									<option value="3">Menadžment</option>
									<option value="4">Poduzetništvo</option>
									<option value="5">Poslovna informatika</option>
								</select>

                                @if ($errors->has('course'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('average_bacc_grade') ? ' has-error' : '' }}">
                            <label for="average_bacc_grade" class="col-md-4 control-label">Prosjek na preddiplomskom:</label>

                            <div class="col-md-8">
                                <input type="number" max="5" step="0.01" min="0" class="form-control" name="average_bacc_grade"/>

                                @if ($errors->has('average_bacc_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_bacc_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* ispunite ukoliko imate završenu barem jednu godinu preddiplomskog studija</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('average_master_grade') ? ' has-error' : '' }}">
                            <label for="average_master_grade" class="col-md-4 control-label">Prosjek na diplomskom</label>

                            <div class="col-md-8">
                                <input type="number" step="0.01" max="5" min="0" step="0.01" class="form-control" name="average_master_grade"/>

                                @if ($errors->has('average_master_grade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('average_master_grade') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* ispunite ukoliko imate završenu barem jednu godinu diplomskog studija</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('internship_town') ? ' has-error' : '' }}">
                            <label for="internship_town" class="col-md-4 control-label">Grad za odrađivanje prakse:</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="internship_town"/>

                                @if ($errors->has('internship_town'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('internship_town') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_company') ? ' has-error' : '' }}">
                            <label for="desired_company" class="col-md-4 control-label">Željena tvrtka:</label>

                            <div class="col-md-8">
                                <textarea type="text" class="form-control" name="desired_company" ></textarea>

                                @if ($errors->has('desired_company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desired_company') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* navesti najviše 5 tvrtki</small></i></div>
                        </div>
						
						<div class="form-group{{ $errors->has('desired_month') ? ' has-error' : '' }}">
                            <label for="desired_month" class="col-md-4 control-label">Željeni mjesec:</label>

                            <div class="col-md-8">
								<select class="form-control" name="desired_month"/>
									<option selected disabled hidden style='display: none'></option>
									<option value="6">Lipanj</option>
									<option value="7">Srpanj</option>
									<option value="8">Kolovoz</option>
									<option value="9">Rujan</option>
								</select>

                                @if ($errors->has('desired_month'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desired_month') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-8 col-md-offset-4"><i><small>* odabarite mjesec kada biste najradije imali praksu</small></i></div>
                        </div>
						
						<h3 style="display:table;margin:auto;margin-top:30px;">Aktivnosti:</h3>
						<div style="display:table;margin:auto;margin-bottom:20px"><i><small>*označite ukoliko ste imali neku od aktivnosti i dajte kratki opis </small></i></div>
						
						<div class="form-group">                            

                            <div class="col-md-12">
								@foreach($activities as $key => $activity)
										<div class="col-sm-offset-2 col-sm-10" style="margin-bottom:10px;">
											<input class="cursor_pointer" type="checkbox" name="activities[{{$key}}]"><label style="display:inline;"> {{ $activity }}</label>
										</div>
										<div class="activity_inputs" hidden>
											<div class="form-group">
												<label class="col-md-2 col-sm-2 control-label" for="year_{{$key}}">Razdoblje: </label>
												<div class="col-md-10 col-sm-10">
													<input name="year_{{$key}}" type="text" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 col-sm-2 control-label" for="description_{{$key}}">Opis: </label>
												<div class="col-md-10 col-sm-10">
													<textarea type="text" name="description_{{$key}}" maxlength="5000" class="form-control"></textarea>
												</div>
											</div>
										</div>
								@endforeach
								
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Spremi
                                </button>
                            </div>
                        </div>
						
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).on("click", ".cursor_pointer", function(){
	$(this).parent().next().fadeToggle("slow");
});
</script>
@endsection