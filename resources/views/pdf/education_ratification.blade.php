<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="charset=utf-8" />
	<title>Potvrda o edukaciji</title>

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
    @page second {
        size: A4 portrait;
    }
    .secondPage {
       position: absolute;
       height: 100%;
       width: 100%;
       page: second;
    }
    .signature {
        text-align: right;
        padding-right: 40px;
        padding-top: 50px;
        
    }
    .second_prf {
       font-size: 15px;
       text-align: justify;
    }
    .textbox2 {
        border-top: 3px solid black
    }
    .footer {
        position: fixed;
        bottom: 34px;
        left: -45px;
        right: -46px;
    }
    </style>
</head>
<body>
	<div class="secondPage">
        <div><img src="../resources/images/header.png"></div><br>

        <div class="textbox2">
            <h2>Potvrda o sudjelovanju na edukaciji o stjecanju poslovnih vještina potrebnim za zapošljavanje</h2><br>
            @foreach($internships as $internship)
                @if($internship->id == $_GET['internship_id'])

                    <h4>{{$internship->student['name'].' '.$internship->student['last_name'] }}</h4><br>
                    <p class="second_prf">Povjerenstvo za studentske stručne prakse izdaje ovu potvrdu studentima koji su sudjelovali na edukaciji u organizaciji Ekonomskog fakulteta u Osijeku, Hrvatske udruge poslodavaca i Hrvatskog zavoda za zapošljavanje – CISOK prije odlaska studenata na dobrovoljnu studentsku stručnu praksu kako bi studenti bili dodatno osposobljeni i informirani o poslovnim vještinama potrebnim za zapošljavanje.<br><br><br>

                    U Osijeku, {{ date('d.m.Y', strtotime($date)) }}</p>

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