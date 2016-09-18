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
        $('.datepicker').datepicker({dateFormat: 'd M, yy'});
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
		.activity_label:hover, .activity_label input:hover {
			cursor: pointer;
		}
		.pagination {
			display: table;
			margin: auto;
		}
		.student_item {
			background-color: #f2f2f2;
			margin-bottom: 4px;
		}
		.unconfirmed_gray {
			color: darkgray;
		}
		.confirmed_green {
			color: darkgreen;
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

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
					@if(!Auth::guest() && Auth::user()->role == "student")
						@if(Utilities::competitionStatus() != 0)
						<li><a href="{{ url('/myapplic')}}"><b>Prijava prakse</b></a></li>
						@endif
						<li><a href=""><b>Moja praksa</b></a></li>
					@endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                   @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @elseif(Auth::user()->role != "student")
						@if(Auth::user()->isAdmin())
						<li><a href="{{ url('/applic/all') }}">Prijave</a></li>
						@endif
						@if(Auth::user()->isAdmin())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prakse <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/internships') }}"><i class="fa fa-btn fa-question-circle" aria-hidden="true"></i>Prijavljene</a></li>
									<li><a href="{{ url('/internships/showFinal') }}"><i class="fa fa-btn fa-check-circle" aria-hidden="true"></i>Konačne</a></li>
									<li><a href="{{ url('/internships/showFormer') }}"><i class="fa fa-btn fa-reply" aria-hidden="true"></i>Prijašnje</a></li>
									@if(Auth::user()->role == 'intern_mentor')						
									<li><a href="{{ url('/internships/showIntern') }}"><i class="fa fa-btn fa-user" aria-hidden="true"></i>Moje prakse</a></li>					                       
                        			@endif
                        			@if(Auth::user()->role == 'college_mentor')						
									<li><a href="{{ url('/internships/showCollege') }}"><i class="fa fa-btn fa-user" aria-hidden="true"></i>Moje prakse</a></li>					                       
                        			@endif
								</ul>
                        </li>
                        @endif
                        @if(Auth::user()->role == 'intern_mentor' && Auth::user()->isAdmin() == false)						
							<li><a href="{{ url('/internships/showIntern') }}">Prakse</a></li>								                        
                        @endif
                        @if(Auth::user()->role == 'college_mentor' && Auth::user()->isAdmin() == false)						
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prakse <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/internships/showFinal') }}"><i class="fa fa-btn fa-check-circle" aria-hidden="true"></i>Konačne</a></li>
									<li><a href="{{ url('/internships/showCollege') }}"><i class="fa fa-btn fa-user" aria-hidden="true"></i>Moje prakse</a></li>	
								</ul>
                        </li>								                        
                        @endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tvrtke <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/company') }}"><i class="fa fa-btn fa-check-circle" aria-hidden="true"></i>Potvrđene</a></li>
									<li><a href="{{  url('/company/wishlist') }}"><i class="fa fa-btn fa-question-circle" aria-hidden="true"></i>Željene</a></li>
									<li><a href="{{  url('/company/former') }}"><i class="fa fa-btn fa-reply" aria-hidden="true"></i></i>Prijašnje</a></li>
								</ul>
                        </li>
						<li class="dropdown">
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Korisnici <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/user/student/list') }}"><i class="fa fa-btn fa-graduation-cap" aria-hidden="true"></i>Studenti</a></li>
								<li><a href="{{ url('/user/college_mentor/list') }}"><i class="fa fa-btn fa-university" aria-hidden="true"></i>Mentori nastavnici</a></li>
								<li><a href="{{  url('/user/intern_mentor/list') }}"><i class="fa fa-btn fa-briefcase" aria-hidden="true"></i>Mentori iz tvrtke</a></li>		
                            </ul>
                        </li>
						@if(Auth::user()->isAdmin())
						<li><a href="{{ url('/settings') }}"><i class="fa fa-btn fa-cogs" aria-hidden="true"></i></i>Natječaj</a></li>
						@endif
					@endif
					@if(!Auth::guest())
						@if(Auth::user()->role == 'student' && Auth::user()->isAdmin() == false)						
							<li><a href="{{ url('/internships/createReport') }}">Prakse</a></li>								                        
                        @endif
                        <li class="dropdown">
                        	 <a class="profile_dropdown" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        	<ul class="dropdown-menu" role="menu">
							@if(Auth::user()->role != "student")
								<li><a href="{{ url('/user') . '/' . Auth::user()->id }}"><i class="fa fa-btn fa-user"></i>Profil</a></li>
							@else
								@if(Utilities::competitionStatus() != 0)
									<li><a href="{{ url('/myapplic')}}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Prijava prakse</a></li>
								@endif
							@endif
                        		<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
						</li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
	  
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	<script>
	$(document).on("click", ".delete", function(){
		var info = $(this).data('info');
		if(confirm('Želite obrisati?')){
		$(this).closest('form').submit();
	}	
	});
	</script>
    @yield('script')
</body>
</html>
