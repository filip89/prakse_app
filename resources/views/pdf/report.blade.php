<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="charset=utf-8" />
	<title>Izvješće o obavljenoj stručnoj praksi</title>

	<style type="text/css">
    * {
      font-family: "DejaVu Sans", monospace;
    }
    p {
    	font-size: 14px;
        text-align: justify;
        page-break-inside: auto;
    }      
    img {
    	background-size: cover;
    	width: 100%;
    }
    a {
    	text-decoration: none;
    }
    .textbox {
		position: relative;
		top: 230px;
		height: 350px;
		padding-bottom: 100px;		
    }
    .footer {
        position: fixed;
        bottom: 34px;
        left: -45px;
        right: -46px;
    }
    .header {
    	position: fixed;
        top: 0px;       
    }
	.activities {
		display: inline;
		border-bottom: 1px solid black;
		font-weight: 400;
		font-size: 15px;
	}
	.form_link {
		font-weight: 700;
		border-top: 1px solid black;
		padding-top: 10px;
	}
	.line1 {
		text-align: center;
		border-bottom: 1px solid black;
		padding-bottom: 10px;
	}
	.line2 {
		border-top: 1px solid black;
		padding-top: 10px;
		font-weight: 700;
		font-size: 15px;
	}
	.bold_line {
		font-weight: 700;
		font-size: 15px;
	}

  </style>
</head>
<body>
<div class="header"><img src="../resources/images/header.png"></div><br>
<div class="footer"><img src="../resources/images/footer.png"></div>
		
@foreach($internships as $internship)	
	<div class="textbox">
		
		<h2 class="line1">Izvješće o obavljenoj stručnoj praksi</h2><br>

        <p class="bold_line">Ja, {{ $internship->student['name'].' '.$internship->student['last_name'] }}, obavio/la sam studentsku stručnu praksu u trajanju od ukupno {{ $internship->duration }} radnih dana u {{ $internship->company['name'] }}. Pretežito sam, uz vodstvo mentora {{ $internship->intern_mentor['name'].' '.$internship->intern_mentor['last_name'] }}, obavljao/la slijedeće aktivnosti:<br><br><span class="activities">{{ $activities }}.</span></p><br>

        <p class="line2">U nastavku, navodim sažetak (cca. 700 riječi) cijelokupnog procesa obavljanja stručne prakse:<br><br><span class="activities">{{ $abstract }}</span></p><br>

        <p class="form_link">Prilog: Evaluacija<br> 
		Ispuniti evaluaciju dostupnu na linku: <a href="http://goo.gl/forms/1luwTQknN7Tpud1j1">http://goo.gl/forms/1luwTQknN7Tpud1j1</a></p>

    </div>

@endforeach	
    

</body>
</html>

	
	
