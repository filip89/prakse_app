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
    
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    
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
	
	$('.scl').hover(function() {
		$('.social').css('z-index', 3);
	}, function() {
		$('.social').css('z-index', 1);
	});

    });

    </script>
    
    <style>
        html, body {
            font-family: 'Lato';
            height: 100%;
		  	margin: 0;
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
		.req_field {
			color: red;
		}
		.navbar-default {
			background-image: url(/images/efos-menu-wrap-bg.png);
			background-size:cover;
			color: white;
		}
		.navbar-default .navbar-brand,.navbar-default .navbar-brand:hover,.navbar-default .navbar-brand:focus {
			color: white;
		}
				
		.navbar-default .navbar-nav > li > a {
			color: white;
		}

		.navbar-default .navbar-nav > li > a:hover,.navbar-default .navbar-nav > li > a:focus {
			background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);
			background-image: -moz-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);
			background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);
			background-image: -ms-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);
			background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.1)), to(rgba(0, 0, 0, 0.1))), url(/images/efos-menu-wrap-bg.png);
			background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);
			background-repeat: repeat;
			background-color: blue !important;
			color: white !important;
		}
		.navbar-default .navbar-nav > li > a:active{
			background-color: blue;
		}
		.dropdown-menu { background-image: url(/images/efos-menu-wrap-bg.png);
			background-size:cover;}
		.dropdown-menu>li>a { 
			color: white
		}
		.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-menu > .active > a:hover {
			color: white;
		}
		.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus {
			background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png);}
		.dropdown.open li a{
			color: white !important;
		}
		.dropdown.open li a:hover, .dropdown.open li a:active, .dropdown.open li a:focus, .dropdown.open li a:visited{
			background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png) !important;
			background-image: -moz-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png) !important;
			background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png) !important;
			background-image: -ms-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png) !important;
			background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.1)), to(rgba(0, 0, 0, 0.1))), url(/images/efos-menu-wrap-bg.png) !important;
			background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)), url(/images/efos-menu-wrap-bg.png) !important;
		}
		.profile_img_container {
			position:relative;
			display:inline-block;
			text-align:center;	
		}
		.profile_img_container .dropdown:hover {
			opacity: 1;
		}
		.profile_img_container > button {
			position: absolute;
			top: 5px;
			right: 5px;
		}
		.profile_img_container .dropdown{
			position: absolute;
			top: 5px;
			right: 5px;
			opacity: 0.8;
		}
		.profile_img_container .dropdown-menu{
			min-width: 0px;
			width: 80px;
			background-image: none !important;
			color: black !important;
		}
		.profile_img_container .dropdown-menu li{
			padding: 3px;
		}
		.profile_img_container .dropdown-menu li:hover{
			cursor: pointer;
			background-color: lightgray;
		}
		.banner-bg {
			display: flex;
			justify-content: center;
			background-image: url({{ URL::asset('images/wrap-bg.png') }});
		}
		.banner-img {			
			background-repeat: repeat;
			height: 125px;
			width: 980px;
		}
		.banner-container {
			position: absolute;
			display: flex;
			flex-direction: row;
			justify-content: space-between;
			width: 60%;
		}
		.banner-logo {
			position: relative;
			width: 250px;
			height: 100px;		
		}
		.banner-logo-faculty {
			position: relative;
			width: 200px;
			height: 80px;			
			margin-top: 20px;
		}
		.banner-txt {
			position: absolute;
			display: block;
			color: white;
			align-self: center;
			text-align: center;
			font-family: "Calibri", Serif;
		}
		.banner-title {
			font-size: 25px;
			color: white;
			font-style: italic;
		}
		.content {
		  min-height: 72%; 
		}
		.footer {
			position: absolute;
			text-align: center;
			width: 100%;
			height: 280px;
			background-image: url({{ URL::asset('images/wrap-bg-2.png') }});
			z-index: 0;
		}
		.push {
			height: 150px;
			clear: both;
		}
		.link-container {
			display: block;
			width: 350px;
		}
		.footer-links {
			padding: 10px;
			width: 100px;
			height: 100px;
		}
		.link-txt {
			color: white;
		}
		.link-txt2 {
			color: white;
			padding-left: 10px;
		}
		.info-txt {
			color: white;
		}
		.popular-link {
			color: white;		
		}
		.popular-link:hover {
			color: black
		}
		.link-box {
			position: relative;
			display: inline-block;
			top: -21px;
		}
		.link-wrapper {
			display: inline-block;
		}
		.info-box {
			display: inline-block;
		}
		.c {
			position: relative;
			top: -80px;
		}
		.social {
			position: relative;
			width: 200px;
			height: 220px;
			position: fixed;
			margin-top: 30px;
			perspective: 1000px;
			list-style: none;
			top: 40%;
			padding-left: 0;
			z-index: 1;	
		}
		.social li a {
			display: inline-block;
			height: 40px;
			width: 40px;
			background: #222;
			border-bottom: 1px solid #333;
			font: normal normal normal
			16px/20px 
			'FontAwesome', 'Source Sans Pro', Helvetica, Arial, sans-serif;
			color: #fff;
			-webkit-font-smoothing: antialiased;
			padding: 10px;
			text-decoration: none;
			text-align: center;
			transition: background .5s ease .300ms
		}

		.social li:first-child a:hover { background: #3b5998 }
		.social li:nth-child(2) a:hover { background: #00acee }
		.social li:nth-child(3) a:hover { background: #ea4c89 }
		.social li:nth-child(4) a:hover { background: #dd4b39 }

		.social li:first-child a { border-radius: 0 5px 0 0 }
		.social li:last-child a { border-radius: 0 0 5px 0 }
		    
		.social li a span {
			width: 100px;
			float: left;
			text-align: center;
			background: #222;
			color: #fff;
			margin: -25px 74px;
			padding: 8px;
			transform-origin: 0;
			visibility: height: 	;n;
			opacity: 0;
			transform: rotateY(45deg);
			border-radius: 5px;
			transition: all .5s ease .300ms;
		}

		.social li span:after {
			content: '';
			display: block;
			width: 0;
			height: 0;
			position: absolute;
			left: -20px;
			top: 7px;
			border-left: 10px solid transparent;
			border-right: 10px solid #222;
			border-bottom: 10px solid transparent;
			border-top: 10px solid transparent;
		}

		.social li a:hover span {
			visibility: visible;
			opacity: 1;
			transform: rotateY(0);
		}
		@media screen and (max-width: 1570px) {
			.social {
				display: none;
			}
		}
		@media screen and (max-width: 1140px) {
			.banner-txt {
				display: none;
			} 
			.panel-responsive {
				width: 500px;
				margin: auto auto;
			}
		}
		@media screen and (max-width: 1075px) {
			.footer {			
				height: 430px;
			} 
			.info-box, .link-box {
				text-align: center;
			}
			.c {
				top: 0;
			}
		}	
		@media screen and (max-width: 720px) {
			.link-wrapper {
				display: flex;
				flex-direction: column;
				align-items: center;
			} 
			.link-box {
				top: 0;
			}
			.footer {
				height: 640px;
			}
			.banner-img {
				width: 100%;
			}
		}		
		@media screen and (max-width: 480px) {
			.banner-logo-faculty {
				display: none;
			}
			.banner-logo {
				left: -40px;
			}
			.panel-responsive {
				width: 300px;
			}
		}
		
    @yield('style')
    </style>
</head>
<body id="app-layout">

	<div>
		<ul class='social'>
			<li>
			    <a class="fa fa-facebook scl" href="https://www.facebook.com/EFOsijek">    
			    	<span>Facebook</span>
			    </a> 
			</li>
		  
			<li>
			    <a class="fa fa-twitter scl" href="https://twitter.com/EFOsijek">
			    	<span>Twitter</span>
			    </a>
			</li>
		  
			<li>
			    <a class="fa fa-linkedin scl" href="https://www.linkedin.com/company/ekonomski-fakultet-u-osijeku">
			    	<span>LinkedIn</span>
			    </a>
			</li>
		  
			<li>
			    <a class="fa fa-google-plus scl" href="https://plus.google.com/104298889578406564718">
			    	<span>Google Plus</span>
			    </a> 
			</li>
		  
		</ul>

	</div>

	<div class="content">
		<div class="banner-bg">
			<img class="banner-img" src="{{ URL::asset('images/efos-header-bg.jpg') }}"/>
			<div class="banner-txt"><span class="banner-title">Ekonomski Fakultet<br> u Osijeku</span></div>
			<div class="banner-container">
				<a href="{{ url('/home') }}"><img class="banner-logo" src="{{ URL::asset('images/HR_logo.png') }}"/></a>
				<img class="banner-logo-faculty" src="{{ URL::asset('images/logo-faks.png') }}"/>
			</div>

		</div>

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
	                        <li><a href="{{ url('/login') }}">Prijava</a></li>
	                        <li><a href="{{ url('/register') }}">Registracija</a></li>
	                    @elseif(Auth::user()->role != "student")
							@if(Auth::user()->role == "college_mentor")
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prijave <span class="caret"></span></a>		
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/applics') }}"><i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Trenutni natječaj</a></li>
									<li><a href="{{ url('/applics/former') }}"><i class="fa fa-btn fa-history" aria-hidden="true"></i>Povijest</a></li>
								</ul>
	                        </li>
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
									<li><a href="{{ url('/user_internships/' . Auth::user()->id)}}"><i class="fa fa-btn fa-folder" aria-hidden="true"></i>Moje prakse</a></li>
								@endif
	                        		<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Odjava</a></li>
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

	    <div class="push"></div>

	</div>

	<!-- Footer -->
    <div class="footer">

    	<div class="info-box c">
	    	<h4 class="link-txt">EFOS POPULARNO</h4>

	    	<div class="link-container">
	    		<p class="info-txt">
					<a class="popular-link" href="http://www.stipendije.info/">stipendije.info</a><br>
					<a class="popular-link" href="https://www.coursera.org/">coursera.org</a><br>
					<a class="popular-link" href="https://www.p2pu.org/en/">P2PU</a><br>
					<a class="popular-link" href="http://www.ted.com/talks">TED Talks</a><br>
					<a class="popular-link" href="https://www.khanacademy.org/">Bloomberg Institute Khan Academy</a>
				</p>
	    	</div>
		</div>

		<div class="link-wrapper">
	    	<div class="info-box">
		    	<h4 class="link-txt">RADNO VRIJEME</h4>

		    	<div class="link-container">
		    		<p class="info-txt">Radno vrijeme referade
						Radnim danom od 9 do 12 sati
						Utorkom (samo za izvanredne studente)
						od 16 do 18.30 sati<br><br>
						Radno vrijeme knjižnice
						ponedjeljak-četvrtak: 8-18 sati
						petak: 8-15 sati<br><br>
						Radno vrijeme skriptarnice
						Ponedjeljak–petak: 9:00h–12:00h
						Utorak: 9:00h–12:00h i 16:00h-18:00h
					</p>
		    	</div>
			</div>
	    	
	    	<div class="link-box">
		    	<h4 class="link-txt2">POVEZNICE</h4>

		    	<div class="link-container">
		    		<a href="http://www.ices.hr/unesco-katedra/"><img class="footer-links" src="{{ URL::asset('images/footer1.png') }}"/></a>
		    		<a href="http://www.efos.unios.hr/studenti/e-ucenje/global-autopoietic-university/"><img class="footer-links" src="{{ URL::asset('images/footer2.png') }}"/></a>
		    		<a href="http://public.mzos.hr/Default.aspx"><img class="footer-links" src="{{ URL::asset('images/footer3.png') }}"/></a>
		    		<a href="http://www.nzpuss.hr/"><img class="footer-links" src="{{ URL::asset('images/footer4.png') }}"/></a>
		    		<a href="http://www.carnet.hr/edukacija"><img class="footer-links" src="{{ URL::asset('images/footer5.png') }}"/></a>
		    		<a href="http://www.unios.hr/"><img class="footer-links" src="{{ URL::asset('images/footer6.png') }}"/></a>
		    	</div>
			</div>
		</div>

    </div>
	  
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
