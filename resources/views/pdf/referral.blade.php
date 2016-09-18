<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="charset=utf-8" />
	<title>Test</title>
	<style type="text/css">
    * {
      font-family: "DejaVu Sans", monospace;
    }
    body {
    	height: 100%;
    }
    h2 {
        text-align: center;
    }
    h3 {
    	text-align: center; 
    	font-size: 22px;
    }
    h4 {
        text-align: center;
    }
    p {
    	font-size: 14px;
        text-align: justify;
    }
      
    img {
    	background-size: cover;
    	width: 100%;
    }
    .signature {
        text-align: right;
        padding-right: 40px;
        padding-top: 50px;
        
    }
    .firstPage {
        position: absolute;
        height: 100%;
        width: 100%;
        page: first;
    }
    .footer {
        position: fixed;
        bottom: 34px;
        left: -45px;
        right: -46px;
    }
    @page first {
        size: A4 portrait;
    }

  </style>
</head>
<body>
    <div class="firstPage">
    	<div><img src="../resources/images/header.png"></div><br>

    	<div class="textbox">
            <h3>Uputnica za studentsku stručnu praksu</h3><br>
        	@foreach($internships as $internship)
        		@if($internship->id == $_GET['internship_id'])
        			<p>Student/ica  {{ $internship->student['name'].' '.$internship->student['last_name'] }}, sveučilišnog preddiplomskog studija Ekonomskog fakulteta u Osijeku, upućuje se u gospodarski subjekt  {{ $internship->company['name'].', '.$internship->company['residence'] }}radi realizacije programa studentske stručne prakse u trajanju od ukupno {{ $internship->duration }} radnih dana. Studentska stručna praksa organizirana je kao dobrovoljni projekt gospodarskih subjekata i Ekonomskog fakulteta u Osijeku temeljem potpisanog Sporazuma o znanstvenoj i stručnoj suradnji, a kako bi studenti stekli dodatna znanja i vještine kojima se nadopunjuje redoviti nastavni proces tijekom studija.</p><br>

        			<p>Student/ica je obavezan pridržavati se Vaših poslovnih pravila i propisa,  a u slučaju nepoštivanja pravila ponašanja od strane studenta/ice na stručnoj praksi, molimo da nas o tome izvijestite. Ukoliko je upućeni student/ica uredno obavio sve svoje obaveze za vrijeme trajanja studentske stručne prakse, molimo Vas da izdate Potvrdu o obavljenoj studentskoj stručnoj praksi u Prilogu.</p><br>

        			<p>Uz izrazito poštovanje, zahvaljujemo na Vašoj susretljivosti i suradnji!</p>

        			<p>U Osijeku, {{ date('d.m.Y', strtotime($date)) }}</p>

        			<p class="signature">@foreach($collegeMentor as $elem) @if($elem->user_id == $internship->college_mentor_id) {{ $elem->title.', ' }} @endif @endforeach {{ $internship->college_mentor['name'].' '.$internship->college_mentor['last_name'] }}, mentor<br>
        			Povjerenstvo<br>
        			za studentske stručne prakse<br>

        			___________________________ <br>
        			Mail: {{ $internship->college_mentor['email'] }} </p>
        		@endif
        	@endforeach
        </div>

    	<div class="footer"><img src="../resources/images/footer.png"></div>
    </div>

</body>

</html>