
<!-- Modal Edit-->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Komentar o obavljenoj praksi
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
               <form class="form-horizontal" role="form" method="POST" action="{{ action('InternshipController@comment') }}">
                    {{ csrf_field() }}
				
				@if(Auth::user()->role == 'student')	
                    <div class="form-group{{ $errors->has('student_comment') ? ' has-error' : '' }}">
						<input type="hidden" name="id" value="{{ $internship->id }}">
                        <label for="student_comment" class="col-md-4 control-label">Komentar</label>
                        <div class="col-md-6">
                            <textarea rows="8" class="form-control" name="student_comment">{{ $internship->student_comment }}</textarea>

                            @if ($errors->has('student_comment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @elseif(Auth::user()->role == 'college_mentor')
					<div class="form-group{{ $errors->has('college_mentor_comment') ? ' has-error' : '' }}">
						<input type="hidden" name="id" value="{{ $internship->id }}">
                        <label for="college_mentor_comment" class="col-md-4 control-label">Komentar</label>
                        <div class="col-md-6">
                            <textarea rows="8" class="form-control" name="college_mentor_comment">{{ $internship->college_mentor_comment }}</textarea>

                            @if ($errors->has('college_mentor_comment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('college_mentor_comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                	<div class="form-group{{ $errors->has('intern_mentor_comment') ? ' has-error' : '' }}">
						<input type="hidden" name="id" value="{{ $internship->id }}">
                        <label for="intern_mentor_comment" class="col-md-4 control-label">Komentar</label>
                        <div class="col-md-6">
                            <textarea rows="8" class="form-control" name="intern_mentor_comment">{{ $internship->intern_mentor_comment }}</textarea>

                            @if ($errors->has('intern_mentor_comment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('intern_mentor_comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
				@endif

                  
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary action_buttons">
                            <i class="fa fa-btn fa-sign-in"></i> Spremi
                        </button>
                    </div>
                </div>
                  
                </form>
                                                                                     
            </div>
            
        </div>
    </div>
</div>