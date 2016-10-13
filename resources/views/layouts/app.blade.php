<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    
    <!-- jQuery & jQuery UI-->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>

    <script>

    $(document).ready(function() {  
    
    	$.ajaxSetup(
	{
	    headers:
	    {
		'X-CSRF-Token': $('input[name="_token"]').val()
	    }
	});
	
        $('.datepicker').datepicker({dateFormat: 'd M, yy'});
        
        $('.competition').on('click', function() {
        	$('.res_box').toggle();
        });

        $('[data-toggle="popover"]').popover({
        	trigger: 'focus'
        });

        $('.comment_text').on('mouseover', function() {
        	$('.comment_button', this).css('display', 'block');
        	$('.test', this).css('opacity', '0.5');
        });

        $('.comment_text').on('mouseout', function() {
        	$('.comment_button', this).css('display', 'none');
        	$('.test', this).css('opacity', '1');
        });
	
	$('#myModalCompany').on('show.bs.modal', function(e) {		    
	    var intId = $(e.relatedTarget).data('id');
	    $(e.currentTarget).find('input[name="internship_id"]').val(intId);
	});
	
	$(':radio').change(function() {
		$('.star').siblings().removeAttr('style');
		var rating = this.value;
		var student_id = $('#student_id').val();
		$.ajax({
			method : 'Post',
			url : 'rating',
			data : { 'rating' : rating,
				 'student_id' : student_id,
			},
		});
	});

    });

    </script>
    
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
		.fa-home {
			font-size: 20px;
		}
		.profile_dropdown {
			font-weight: bold;
			font-size: 16px;
		}
		
		th {
			font-size: 16px;
		}
		h1 {
			text-align: center;
			margin-bottom: 30px;
		}
		#add_button {
			width: 100%;
			margin-bottom: 20px;
			font-size: 18px;
		}
		.row_buttons a, .row_buttons button{
			display: inline-block;
			height: 30px;
			font-size: 12px;
		}
		.row_buttons form {
			display: inline;
		}
		td {
			width: 20%;
		}
		.row_buttons {
			text-align: right;
			min-width: 200px;
		}
		a:link {
			text-decoration: none;
		}
		a:visited {
			text-decoration: none;
		}
		a:hover {
			text-decoration: none;
		}
		a:active {
			text-decoration: none;
		}
		
		.action_buttons form {
			display: inline;
		}
		.action_buttons {
			display: table;
			margin: auto;
		}
		.profile_table {
			margin-top: 30px;
			text-align: center;
		}
		.link_object {
			font-weight: bold;
		}
		.panel-heading {
			font-size: 16px;
			font-weight: bold;
		}
		.panel th{
			font-weight: normal;
		}
		.panel td{
			font-weight: bold;
		}
		.alert {
			width: 250px;
			margin: auto;
			text-align: center;
			margin-bottom: 20px;
		}
		.cursor_pointer {
			cursor: pointer;
		}
		.pagination {
			display: table;
			margin: auto;
		}
		.user_item {
			background-color: #f2f2f2;
			margin-bottom: 4px;
		}
		.expired_gray {
			color: darkgray;
		}
		.current_green {
			color: darkgreen;
		}
		.settings_fa {
			font-size: 20px;
		}
		h3{
			text-align: center;
			color: gray;
		} 
		.little_info {
			font-size: 12px;
			font-weight: bold;
			background-color: #f2f2f2;
			padding: 10px;
		}
		.centered {
			text-align: center;
			vertical-align: middle !important;
		}
		.circle {
			display: block;
			width: 30px;
			height: 30px;	
			border-radius: 50%;	
			margin: auto auto;
		}
		.yes {
			border: 3px solid #4cae4c;
		}
		.no {
			border: 3px solid #d43f3a;
		}
		.y {
			margin-top: 20%;
			color: #5cb85c;
		}
		.x {
			margin-top: 20%;
			color: #d9534f;
		}
		.search-btn {
			position: absolute;
			height: 34px;
		}
		.search_box {
			display: block;
			position: absolute;
			width: 200px;
			right: 0;
			top: 20px;
		}
		
		.profile_img_container {
			position:relative;
			display:inline-block;
			text-align:center;	
		}
		.profile_img_container > button {
			position:absolute;
			bottom:5px;
			right:5px;
			opacity: 0;
		}
		.profile_img_container button {
			width: 50px;
			height: 50px;
			transition: opacity 0.5s;	
		}
		.profile_img_container:hover button {
			opacity: 0.8;
		}
		.profile_img_container:hover button:hover {
			opacity: 1;
		}

		.profile_img_container form button {
			position: absolute;
			bottom: 5px;
			left: 5px;
			opacity: 0;
		}
		.req_field {
			color: red;
		}

    @yield('style')
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
					@if(!Auth::guest() && Auth::user()->role == "student")
						@if(Utilities::competitionStatus() != 0)
						<li>
							<a href="{{ url('/myapplic')}}">			
									@if(Auth::user()->activeApplic())
									<b><i class="fa fa-btn fa-pencil-square" aria-hidden="true"></i>Prijavljena praksa</b>
									@elseif(Utilities::competitionStatus() == 1)
									<b><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Prijava prakse</b>
									@endif
							</a>
						</li>
						@endif
						@if(Auth::user()->lastInternship())
							<li><a href="{{ url('/myinternship')}}"><b><i class="fa fa-btn fa-folder" aria-hidden="true"></i>Moja praksa</b></a></li>
						@endif
					@if(Utilities::competitionExists() == 1)
					<li><a href="{{ url('/internships/showResults') }}"><b><i class="fa fa-btn fa-trophy" aria-hidden="true"></i>Rezultati</b></a></li>							
					@endif
					<li><a href="{{  url('/complaint') }}"><i class="fa fa-btn fa-question" aria-hidden="true"></i>Postavi pitanje</a></li>
					@endif
					<li><a href="{{  url('/committee') }}"><i class="fa fa-btn fa-users" aria-hidden="true"></i>Povjerenstvo</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
					@if(Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @elseif(Auth::user()->role != "student")
						@if(Auth::user()->isAdmin())
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prijave <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/applics') }}"><i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Trenutni natječaj</a></li>
									<li><a href="{{ url('/applics/former') }}"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Povijest</a></li>
								</ul>
                        				</li>
						@endif
						@if(Auth::user()->role == "college_mentor")
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prakse <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									@if(Auth::user()->isAdmin())
									<li><a href="{{ url('/internships') }}"><i class="fa fa-btn fa-question-circle" aria-hidden="true"></i>Prijavljene</a></li>
									@endif
									<li><a href="{{  url('/internships/showFinal') }}"><i class="fa fa-btn fa-check-circle" aria-hidden="true"></i>Konačne</a></li>
									<li><a href="{{  url('/internships/showResults') }}"><i class="fa fa-btn fa-trophy" aria-hidden="true"></i>Rezultati</a></li>
								</ul>
                        </li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tvrtke <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/company') }}"><i class="fa fa-btn fa-check-circle" aria-hidden="true"></i>Pohranjene</a></li>
									<li><a href="{{  url('/company/wishlist') }}"><i class="fa fa-btn fa-question-circle" aria-hidden="true"></i>Željene</a></li>
								</ul>
                        </li>
						
						<li class="dropdown">
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Korisnici <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/user/student/list') }}"><i class="fa fa-btn fa-graduation-cap" aria-hidden="true"></i>Studenti</a></li>
								<li><a href="{{ url('/user/college_mentor/list') }}"><i class="fa fa-btn fa-university" aria-hidden="true"></i>Mentori nastavnici</a></li>
								<li><a href="{{  url('/user/intern_mentor/list') }}"><i class="fa fa-btn fa-briefcase" aria-hidden="true"></i>Mentori iz tvrtke</a></li>
								@if(Auth::user()->isAdmin())
								<li><a href="{{  url('/complaints') }}"><i class="fa fa-btn fa-exclamation-circle " aria-hidden="true"></i>Pitanja</a></li>
								@endif
                            </ul>
                        </li>
						@endif
						@if(Auth::user()->isAdmin())
						<li><a href="{{ url('/settings') }}"><i class="fa fa-btn fa-cogs" aria-hidden="true"></i></i>Postavke</a></li>
						<li><a href="{{ url('/internships/statistics') }}"><i class="fa fa-btn fa-bar-chart" aria-hidden="true"></i>Statistika</a></li>
						@endif
					@endif
					@if(!Auth::guest())
                        <li class="dropdown">
                        	 <a class="profile_dropdown" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        	<ul class="dropdown-menu" role="menu">
							
								<li><a href="{{ url('/user') . '/' . Auth::user()->id }}"><i class="fa fa-btn fa-user"></i>Profil</a></li>
							@if(Auth::user()->role != "student")
								<li><a href="{{ url('/user_internships')}}"><i class="fa fa-btn fa-folder" aria-hidden="true"></i>Moje prakse</a></li>
							@endif
                        		<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
						</li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

	<!-- Modal -->
  <div class="modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Jeste li sigurni?</h4>
        </div>
        <div class="modal-body">
          @yield('modal_body_content') <span class="data_info"></span>?
        </div>
        <div class="modal-footer">
			<button type="button" id="submit_delete" class="btn btn-danger" data-dismiss="modal">Da</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Ne</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Delete profile image -->
    <div class="modal fade" id="profile_deleteImg_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Jeste li sigurni?</h4>
        </div>
        <div class="modal-body">
          Ukloniti sliku profila?
        </div>
        <div class="modal-footer">
			<button type="button" id="submit_delete" class="btn btn-danger" data-dismiss="modal">Da</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Ne</button>
        </div>
      </div>
      
    </div>
  </div>
  
    <div class="modal fade" id="profile_addImg_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Dodajte svoju sliku profila</h4>
        </div>
		{{ Form::open( [ 'url' => '/user/image/add/', 'method' => 'post', 'files' => true ] ) }}
			 {{ csrf_field() }}
			<div class="modal-body">		
				<input type="file" name="image_file" />	
				<small>* Dopušteni formati: jpeg, png, bmp, gif </small>			
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Dodaj</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Odustani</button>
			</div>
		{{ Form::close() }}
      </div>
      
    </div>
	</div>

    @yield('content')
	  
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	<script>
	/*$(document).on("click", ".delete", function(){
		var info = $(this).data('info');
		if(confirm('Želite obrisati?')){
		$(this).closest('form').submit();
	}	
	});
	*/
	var deletee;
	var data;
	
	$('[data-toggle="tooltip"]').tooltip(); 

	$(document).on("click", ".delete", function(){
		data = $(this).data('info');
		$('#delete_modal').modal();
		$('.data_info').text(data);
		deletee = $(this);
	});
	$(document).on("click", ".delete_img", function(){
		$('#profile_deleteImg_modal').modal();
		deletee = $(this);
	});
	
	$(document).on("click", "#submit_delete", function(){
		deletee.closest('form').submit();
	});
	
	</script>
    @yield('script')
</body>
</html>
