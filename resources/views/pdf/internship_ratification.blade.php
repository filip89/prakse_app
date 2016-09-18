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
    .info {
        font-size: 12px;
    }
    .reference {
        font-size: 10px;
        text-align: justify;
        padding-top: 30px;
    }
    .lines {
        width: 100%;
        text-align: justify;
    }
    .textbox3 {
        position: absolute;
        top: 210px;
    }
    .title {
        display: block;
        height: 40px;
        border-bottom: 2px solid black;
    }
    .ref_line {
        position: absolute;
        display: block;
        border-bottom: 1px solid black;
        width: 30%;
        bottom: 90px;
    }
    .signature3 {
        position: absolute;
        right: 0;
        bottom: 130px;
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
    <div class="thirdPage">
        <div><img src="../resources/images/header.png"></div><br>

        <div class="textbox3">
            <h2 class="title">Potvrda o obavljenoj studentskoj stručnoj praksi<sup>1</sup></h2>
            <p class="third_prf">Student/ica Ekonomskog fakulteta u Osijeku</p>
            @foreach($internships as $internship)
                @if($internship->id == $_GET['internship_id'])

                    <h4>{{$internship->student['name'].' '.$internship->student['last_name'] }}</h4>

                    <p class="third_prf">obavio/la je studentsku stručnu praksu u gospodarskom subjektu</p>

                    <h4>{{ $internship->company['name'].', '.$internship->company['residence'] }}</h4>
                    
                    <p class="third_prf">radi realizacije programa studentske stručne prakse u trajanju od ukupno {{ $internship->duration }} radnih dana. Aktivnosti koje je je uključivala studentska stručna praksa su slijedeće <span class="info">(molimo mentora gospodarskog subjekta da upiše aktivnosti):</span> </p>
                    <p class="lines">_____________________________________________________________________________________________________
                                     _____________________________________________________________________________________________________
                                     _____________________________________________________________________________________________________
                                     _____________________________________________________________________________________________________
                                     _____________________________________________________________________________________________________
                                     s voditeljem/mentorom <span class="info">(upisati ime, prezime i funkciju mentora)</span> ___________________________________
                                     _____________________________________________________________________________________________________
                                     __________________________________________ u odjelu <span class="info">(upisati naziv odjela)</span> ________________________
                                     _____________________________. </p><br>
                    <p class="third_prf">Ovim putem potvrđujemo kako su, tijekom cijelog vremena trajanja studentske stručne prakse, poštovana poslovna pravila i propisi, kao i interni poslovni procesi.<sup>2</sup><p><br>

                    <p>Mjesto i datum:______,_______.<p class="signature3">Odgovorna osoba:___________________________<br>Potpis i žig:__________________________________</p></p> 
                    <p class="ref_line"></p>
                    <p class="reference"><sup>1</sup>Potvrdu je potrebno dostaviti mentoru/Povjerenstvu za studentske stručne prakse Ekonomskog fakulteta u Osijeku po završetku studentske stručne prakse (osobno putem studenta ili poštom).<br><sup>2</sup>U slučaju da student/studentica nije zadovoljila Vaše kriterije ili imate primjedbe, molimo Vaš dopis s obrazloženjem kako bismo, u budućoj suradnji, pokušali rješiti uočene probleme.</p>
       
                @endif
            @endforeach
        </div>

        <div class="footer"><img src="../resources/images/footer.png"></div>

    </div>
</body>
</html>