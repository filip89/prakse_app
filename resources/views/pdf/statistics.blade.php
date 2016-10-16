@extends('layouts.app')

@section('content')

<script>
$(document).ready(function() {
	//  Statistics Chart
	var arr = {!! json_encode($internships) !!};
	var arr2 = {!! json_encode($course) !!};
	var arr2 = $.map(arr2, function(value, index) {
		return value;
	});
	var arr3 = {!! json_encode($activity) !!};

	var arr4 = {!! json_encode($applic) !!};
	var arr4 = $.map(arr4, function(value, index) {
		return value;
	});

	var counts = [];
	for(var i=0; i< arr.length; i++)
	{
	  var key = arr[i];
	  counts[key] = (counts[key])? counts[key] + 1 : 1 ;
	}

	var counts2 = [];
	for(var i=0; i< arr2.length; i++)
	{
	  var key = arr2[i];
	  counts2[key] = (counts2[key])? counts2[key] + 1 : 1 ;
	}

	var counts3 = [];
	for(var i=0; i< arr3.length; i++)
	{
	  var key = arr3[i];
	  counts3[key] = (counts3[key])? counts3[key] + 1 : 1 ;
	}

	google.charts.load('current', {packages: ['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
	    var data = google.visualization.arrayToDataTable([
	    	['Ocjena 1', counts[1]],		    	
	    	['Ocjena 2', counts[2]],
	    	['Ocjena 3', counts[3]],
	    	['Ocjena 4', counts[4]],		    	
	    	['Ocjena 5', counts[5]]
	    ], true);

	    var data2 = google.visualization.arrayToDataTable([
	    	['Financijski menadžment', counts2[1]],		    	
	    	['Marketing', counts2[2]],
	    	['Menadžment', counts2[3]],
	    	['Poduzetništvo', counts2[4]],		    	
	    	['Poslovna informatika', counts2[5]]
	    ], true);

	    var data3 = google.visualization.arrayToDataTable([
	    	['Članstvo u udrugama; rad u studentskoj organizaciji', counts3[1]],		    	
	    	['Studentsko predstavljanje (zbor, smotra, senat...)', counts3[2]],
	    	['Rad na znanstvenom projektu, izlaganja ili uređivanje studentskih, znanstvenih ili stručnih časopisa', counts3[3]],
	    	['Seminari/radionice (organizacija/sudjelovanje)', counts3[4]],		    	
	    	['Sudjelovanje u Erasmus programu i/ili rd u inozemstvu tijekom studija', counts3[5]],
	    	['Rad preko studentskog centra', counts3[6]],
	    	['Demonstratura tijekom preddiplomskog i/ili diplomskog studija', counts3[7]],
	    	['Rektorova i/ili dekanova nagrada', counts3[8]],
	    	['Sudjelovanje u studentskim natjecanjima i ostvareno jedno od prva tri mjesta', counts3[9]]
	    ], true);

	    var options = {
	    	title: 'Ocjena prakse',
	    	pieHole: 0.4,
	    };

	    var options2 = {
	    	title: 'Prakse po smjerovima',
	    };

	     var options3 = {
	    	title: 'Izvannastavne aktivnosti',
	    	pieHole: 0.4,
	    };

	    if(document.getElementById('first_chart')) {
	    	var chart = new google.visualization.PieChart(document.getElementById('first_chart'));
	    	chart.draw(data, options);

	    	//Get average rating
			arr = arr.filter(function(n){ return n != null }); 
		    var total = 0;
		    $.each(arr, function() {
		    	total += this;
		    });
		    avg_rating = total/arr.length;
		    document.getElementById('avg_rating').innerHTML=avg_rating;

	    }
	    
	    if(document.getElementById('third_chart')) {
	    	var chart3 = new google.visualization.PieChart(document.getElementById('third_chart'));
	    	chart3.draw(data3, options3);

	    	//Get average activity    
		    avg_activity = arr3.length/arr4.length;
		    document.getElementById('avg_activity').innerHTML=avg_activity;
	    }	

	    if(document.getElementById('second_chart')) {
	    	var chart2 = new google.visualization.PieChart(document.getElementById('second_chart'));
		    chart2.draw(data2, options2);

	    }  
	}
});

</script>

<style>
	h2 {
		text-align: center;
		line-height: 50px;
	}
	.chart-container {
		display: flex;
		justify-content: center;
		flex-direction: row;
	}
	.chart-container2 {
		display: flex;
		justify-content: center;
		flex-direction: row-reverse;
	}
	.chart-desc, .chart-desc2 {
		display: flex;
		flex-direction: column;
		align-items: center;
		width: 50%;
		padding: 20px;
	}
	.chart-desc2 {
		position: relative;
		width: 65%;
	}
	.chart-img {
		width: 50%;
	}
	.chart-img2 {
		width: 35%;
	}
	.chart-title {
		height: 20%;
		width: 100%;
		text-align: left;
	}
	.chart-text, .chart-text2 {
		height: 80%;
		width: 100%;
		font-size: 15px;
		text-align: left;
		line-height: 30px;	
	}
	.chart-text2 {
		overflow: auto;
		line-height: 50px;
	}
	.title {
		font-weight: 600;
		font-size: 17px;
		text-decoration: underline;
	}
	#int_number, #avg_rating, #max_rating, #avg_activity {
		display: block;
		float: right;
		padding-right: 10px;
	}
	#max_course, #max_activity {
		display: block;
		position: relative;
		width: 50%;
		text-align: right;
		float: right;
		padding-right: 10px;
	}
	#max_activity {
		line-height: 20px;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Statistčko izvješće za razdoblje<br> {{ date('d.m.Y', strtotime($start_date)) }} do {{ date('d.m.Y', strtotime($end_date)) }}</h2><br>
			@if(count($internships) == null)
				<h3>Nema podataka za zadano razdoblje</h3><br>
				<a type="button" class="btn btn-primary action_buttons" href="{{ URL::previous() }}">Povratak</a>
			@else
			    <div class="thumbnail">
					<div class="chart-container">
					@if($max_rating == null)
						<h3 class="centered" style="margin-top: 10px;">Podaci o ocjenama studenata nedostupni zbog nedostatka informacija</h3>	
					@else
						<div class="chart-desc">
							<div class="chart-title"><span class="title">Podaci o ocjenama praksi u zadanom razdoblju</span></div>

							<div class="chart-text">Ukupan broj studentskih praksi u zadanom razdoblju:  <span id="int_number">{{ count($internships) }}</span><br>
							Prosječna ocjena prakse: <span id="avg_rating"></span><br>
							Najučestalija ocjena: <span id="max_rating">
							@foreach($max_rating as $max) {{ $max }}
								@if(count($max_rating) > 1 && $max != end($max_rating)) i 
								@endif 
							@endforeach
							</span>

							</div>
						</div>

						<div class="chart-img" id="first_chart" style="width: 700px; height: 350px; margin-right: 20px;"></div>
					@endif
					</div>
				    
			    </div>


				<div class="thumbnail">
					<div class="chart-container2">
						<div class="chart-desc">					

							<div class="chart-title"><span class="title">Podaci o smjerovima u zadanom razdoblju</span></div>

							<div class="chart-text">Ukupan broj studentskih praksi u zadanom razdoblju:  <span id="int_number">{{ count($internships) }}</span><br>
							Smjer s najvećim brojem praksi: <span id="max_course">
							@foreach($max_course as $max) {{ Utilities::course($max) }}
								@if(count($max_course) > 1 && $max != end($max_course)) <br> 
								@endif 
							@endforeach
							</span><br>						
							</div>

						</div>

						<div class="chart-img" id="second_chart" style="width: 700px; height: 350px; margin-right: 20px;"></div>
						
					</div>
				    
			    </div>


			    <div class="thumbnail">
					<div class="chart-container">
							
						@if($max_activity == null)
							<h3 class="centered" style="margin-top: 10px;">Podaci o izvannastavnim aktivnostima nedostupni zbog nedostatka informacija</h3>	
						@else
							<div class="chart-desc2">					

								<div class="chart-title"><span class="title">Podaci o izvannastavnim aktivnostima u zadanom razdoblju</span></div>

								<div class="chart-text2">Ukupan broj studentskih praksi u zadanom razdoblju:  <span id="int_number">{{ count($internships) }}</span><br>
								Prosječan broj izvannastavnih aktivnosti po studentu: <span id="avg_activity"></span><br>
								Najučešća izvannastavna aktivnost: <span id="max_activity">
								@foreach($max_activity as $max) {{ Utilities::activity($max) }}
									@if(count($max_activity) > 1 && $max != end($max_activity)) <br><br> 
									@endif 
								@endforeach
								</span><br>
								
								</div>

							</div>

						<div class="chart-img2" id="third_chart" style="width: 700px; height: 350px; margin-right: 20px;"></div>
						@endif
					</div>
				    
			    </div>
			@endif
		</div>
		 
	</div>
</div>
@endsection

