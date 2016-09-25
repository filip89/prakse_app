<h3>Podaci o studentu:</h3>
     
<div class="table-responsive">
    <table class="table table-striped">
    <tbody>
        <tr>
            <th>Akademska godina</th>
            <td  colspan="2">{{ Utilities::academicYear($app->academic_year) }}</td>
        </tr>

        <tr>
            <th>Smjer</th></td>
            <td  colspan="2">{{ Utilities::course($app->course) }}</td>
        </tr>

        <tr>
            <th>E-mail</th></td>
            <td  colspan="2">{{ $app->email }}</td>
        </tr>

        <tr>
            <th>Prosjek ocjena (preddipl.)</th>                         
            <td  colspan="2">{{ $app->average_bacc_grade }}</td>
        </tr>

        <tr>
            <th>Prosjek ocjena (dipl.)</th>
            <td  colspan="2">{{ $app->average_master_grade }}</td>
        </tr>

        <tr>
            <th>Tvrtka</th>
            <td  colspan="2">{{ $app->desired_company }}</td>
        </tr>

        <tr>
            <th>Željeni mjesec obavljanja prakse</th>
            <td  colspan="2">{{ Utilities::desiredMonth($app->desired_month) }}</td>
        </tr>

        <tr>
            <th>Mjesto prebivališta</th>
            <td  colspan="2">{{ $app->residence_town }}</td>
        </tr>

        <tr>
            <th>Županija prebivališta</th>
            <td  colspan="2">{{ Utilities::county($app->residence_county) }}</td>
        </tr>

        <tr>
            <th>Grad obavljanja prakse</th>
            <td  colspan="2">{{ $app->internship_town }}</td>
        </tr>

        {{--*/ $count = 1 /*--}}
        @if(count($activities) == 0)
            <th>Izvannastavne aktivnosti</th>
            <td>Nema aktivnosti</td>
        @else                      
            @foreach($activities as $act)
                            
            <tr>
                @if($count == 1)
                    <th>Izvannastavne aktivnosti</th>
                @else
                    <th></th>
                @endif
                <td colspan="2"><div style="cursor: pointer; outline: 0;" tabindex="0" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="top" data-html="true" data-content="<b>Godina:</b> {{ $act->year }} <br><br><b>Opis:</b> {{ $act->description }}">{{ Utilities::activity($act->number) }}</div></td>
                {{--*/ $count += 1 /*--}}  
            </tr>                                   
               
            @endforeach 
            
            <tr>
                <th colspan="2"><div class="btn btn-primary competition">Bodovanje izvannastavnih aktivnosti</div></th>
            </tr>
            <tr>
                <td style="background-color: white;" colspan="2">
                <div class="res_box">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        
                            <thead>
                                <tr style="background-color: #e7e7e7;">
                                    <th>Broj izvannastavnih aktivnosti</th>
                                    <th>Broj dodijeljenih bodova temeljem izvannastavnih aktivnosti</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <th>1</th>
                                </tr>

                                <tr>
                                    <th>2 - 3</th>
                                    <th>2</th>
                                </tr>

                                <tr>
                                    <th>4 - 5</th>
                                    <th>3</th>
                                </tr>

                                <tr>
                                    <th>6 - 7</th>
                                    <th>4</th>
                                </tr>

                                <tr>
                                    <th>8 - 10</th>
                                    <th>5</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </td>                           
            </tr>
            @endif          
        </tbody>
    </table>
</div>        

