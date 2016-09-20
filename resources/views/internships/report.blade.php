@extends('layouts.app')

@section('content')
<style>
    ::-webkit-input-placeholder {
        font-style: italic;
        text-align: justify;
    }
    ::-moz-placeholder { 
        font-style: italic;
        text-align: justify;
    } 
    :-ms-input-placeholder {  
        font-style: italic;
        text-align: justify;
    }
    input:-moz-placeholder { 
        font-style: italic;
        text-align: justify;
    }

</style>
<div class="container">

@if(count($internships) != null)
    @foreach($internships as $internship)
        @if($internship->student_id == Auth::user()->id && $internship->status == 0)
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Izvješće o obavljenoj praksi</div>
                <div class="panel-body">  
    		
    				<form class="form-horizontal" role="form" method="POST" action="{{ action('InternshipController@getReport') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="student_id" value="{{ Auth::user()->id }}"> 
                           
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $internship->student['name'] }}" disabled>
                            </div>
                        </div>

    					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Prezime</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ $internship->student['last_name'] }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('activities') ? ' has-error' : '' }}">
                            <label for="activities" class="col-md-4 control-label">Aktivnosti</label>

                            <div class="col-md-6">
                                <textarea rows="10" class="form-control" name="activities"></textarea>

                                @if ($errors->has('activities'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('activities') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('abstract') ? ' has-error' : '' }}">
                            <label for="abstract" class="col-md-4 control-label">Sažetak<br>(cca. 700 riječi)</label>

                            <div class="col-md-6">
                                <textarea rows="15" class="form-control" name="abstract" placeholder="Upisati kako je izgledao “doček” u poduzeće, kako su Vas rasporedili; jeste li se upoznali s osnovama ukupnog procesa poduzeća pa su Vas onda rasporedili u odgovarajući odjel? Kako Vam se svidjelo okruženje i radna atmosfera? Koje ste konkretne poslove obavljali? Što možete istaknuti kao dobre, a što kao loše strane cijelog procesa obavljanja prakse?"></textarea>

                                @if ($errors->has('abstract'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('abstract') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

    					<button type="submit" class="btn btn-success action_buttons">Izradi izvješće</button>		

    				</form>
    				
                </div>
            </div>
        </div>
        @else
            <h3>Za izradu izvještaja potrebno je dobiti praksu</h3>
        @endif
    @endforeach
@else
    <h3>Za izradu izvještaja potrebno je prijaviti i dobiti praksu</h3>
@endif
</div>  

@endsection

