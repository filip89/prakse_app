@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-btn fa-briefcase" aria-hidden="true"></i>Nova tvrtka</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('company/create') }}">
                        {{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"><span class="req_field">* </span>Naziv:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('residence') ? ' has-error' : '' }}">
                            <label for="residence" class="col-md-4 control-label"><span class="req_field">* </span>Sjedište:</label>

                            <div class="col-md-6">
                                <input type="txt" class="form-control" name="residence" value="{{ old('residence') }}" required>

                                @if ($errors->has('residence'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('residence') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><span class="req_field">* </span>E-mail:</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label"><span class="req_field">* </span>Telefon:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('spots') ? ' has-error' : '' }}">
                            <label for="spots" class="col-md-4 control-label"><span class="req_field">* </span>Mjesta za prakse:</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" min="0" name="spots" value="{{ old('spots') }}" required>

                                @if ($errors->has('spots'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spots') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('field') ? ' has-error' : '' }}">
                            <label for="field" class="col-md-4 control-label">Područje:</label>

                            <div class="col-md-6">
                                <select onchange="field_select(this)" class="form-control select_field" name="field ">
									<option style="display:none" selected disabled hidden ></option>
									@foreach(Utilities::companyFields() as $key => $field)
									<option value="{{ $key }}">{{ $field }}</option>
									@endforeach
									<option id="other_field">Ostalo</option>
								</select>

                                @if ($errors->has('field'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('field') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-6 col-md-offset-4"><i><small>* područje iz kojeg se prima student na praksu</small></i></div>
							<div id="other_field_div" class="col-md-6 col-md-offset-4" style="margin-top:10px;display:none"><input maxlength="40" type="text" class="form-control other_input" value="{{ old('field') }}" placeholder="Ovdje upišite područje" /></div>
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
function field_select(select){
	
	if($(select).children(':selected').attr('id') == 'other_field'){
		
		if($('#other_field_div').is(':hidden')){

			$('#other_field_div').fadeIn();
			
		}
		else{
			
			$('#other_field_div').fadeOut();
			
		}
			
	}
	else if(!$('#other_field_div').is(':hidden')){		
		
		$('#other_field_div').fadeOut();
				
	}	
	if($(select).children(':selected').attr('id') != 'other_field'){
		
		$('.select_field').attr('name', 'field');
		$('.other_input').removeAttr('name');
		
	}
	else{
		
		$('.other_input').attr('name', 'field');
		$('.select_field').removeAttr('name');
		
	}

}
</script>
@endsection
