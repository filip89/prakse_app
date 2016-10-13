@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
				@if(!$competition)
					<div class="panel panel-default">
						<div class="panel-body">Trenutno nema otvorenog natječaja.</div>
					</div>
				@endif
				@if(Utilities::competitionStatus() == 1)
					<div class="panel panel-default">
						<div class="panel-heading">{{ $competition->created_at->format('d. m. Y.') }}</div>
						<div class="panel-body">
							<p>Objavljen je natječaj za prakse koji traje do ponoći {{ date_create($competition->end_date)->format('d. m. Y.') }}.<br/></p>
							<p>{{ $competition->message }}</p>
							<p>Postupak prijava za praksu možete pogledati <a href="#">ovdje.</a></p>
						</div>
					</div>
				@elseif(Utilities::competitionStatus() == 2)
					<div class="panel panel-default">
						<div class="panel-heading">{{ date_create($competition->end_date)->format('d. m. Y.') }}</div>
						<div class="panel-body">
							<p>Natječaj objavljen {{ $competition->created_at->format('d. m. Y.') }} je završio, u tijeku je postupak dodjela praksi.</p>
						</div>
					</div>
				@endif	
				@if(Utilities::competitionExists())
				<div class="panel panel-default">
					<div class="panel-heading">{{ date_create($lastCompetition->results_date)->format('d. m. Y.') }}</div>
						<div class="panel-body">					
							<p>Objavljeni su <a href="/internships/showResults">rezultati</a> posljednjeg natječaja (objavljenog {{ date_create($lastCompetition->created_at)->format('d. m. Y.') }} ).</p>
							<p>{{ $lastCompetition->message }}</p>
					</div>
				</div>
				@endif
        </div>
    </div>
</div>
@endsection