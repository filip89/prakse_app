<?php

namespace App;

class Utilities
{
	
   	private static $academic_years = array('1. godina preddiplomskog', '2. godina preddiplomskog', '3. godina preddiplomskog', '1. godina diplomskog', '2. godina diplomskog');
	
	private static $courses = array('Financijski menadžment', 'Marketing', 'Menadžment', 'Poduzetništvo', 'Poslovna informatika');
	
	private static $desired_months = array(1 => 'Siječanj', 2 => 'Veljača', 3 => 'Ožujak', 4 => 'Travanj', 5 => 'Svibanj', 6 => 'Lipanj', 7 => 'Srpanj', 8 => 'Kolovoz', 9 => 'Rujan', 10 => 'Listopad', 11 => 'Studeni', 12 => 'Prosinac');
	
	private static $activities = array('Članstvo u studentskoj i/ili civilnim udrugama; rad u studentskoj organizaciji koja je registrirana ili upisana u upisnik studentskih organizacija.', 'Studentsko predstavljanje u sveučilišnim ili drugim tijelima relevantnim za sustav znanosti i visokog obrazovanja (Senat, Studentsko zbor, Smotra).', 'Rad na znanstvenom projektu; izlaganje na znanstvenom i/ili stručnom skupu; uređivanje studentskih, znanstvenih ili stručnih časopisa (glavni urednik, tajnik/tajnica, članovi uredništva).', 'Izlaganje ili sudjelovanje u organizaciji ljetnih škola, znanstvenih i/ili stručnih skupova.', 'Seminari/radionice (organizacija/sudjelovanje).', 'Sudjelovanje u Erasmus programu i/ili rd u inozemstvu tijekom studija.', 'Rad preko studentskog centra.', 'Demonstratura tijekom preddiplomskog i/ili diplomskog studija.', 'Rektorova i/ili dekanova nagrada.', 'Sudjelovanje u studentskim natjecanjima i ostvareno jedno od prva tri mjesta.');
	
	private static $counties = array(1 => 'Krapinsko-zagorska županija', 2 => 'Sisačko-moslavačka županija', 3 => 'Međimurska županija', 4 => 'Karlovačka županija', 5 => 'Varaždinska županija', 6 => 'Koprivničko-križevačka županija', 7 => 'Bjelovarsko-bilogorska županija', 8 => 'Primorsko-goranska županija', 9 => 'Ličko-senjska županija', 10 => 'Virovitičko-podravska županija', 11 => 'Požeško-slavonska županija', 12 => 'Brodsko-posavska županija', 13 => 'Zadarska županija', 14 => 'Osječko-baranjska županija', 15 => 'Šibensko-kninska županija', 16 => 'Splitsko-dalmatinska županija', 17 => 'Vukovarsko-srijemska županija', 18 => 'Istarska županija', 19 => 'Dubrovačko-neretvanska županija', 20 => 'Grad Zagreb', 21 => 'Zagrebačka županija', 22 => 'Inozemstvo');
	
	public static function academicYear($year){
		
		if(!isset($year)){
			return false;
		}
		
		return self::$academic_years[$year - 1];
		
	}
	
	public static function course($course){
		
		if(!isset($course)){
			return false;
		}
		
		return self::$courses[$course - 1];
		
	}
	
	public static function desiredMonth($month){

		if(!isset($month)){
			return false;
		}
		
		return self::$desired_months[$month];
		
	}
	
	public static function activity($num){
				
		if(!isset($num)){
			return false;
		}
			
		return self::$activities[$num - 1];
		
	}
	
	public static function competitionStatus(){
		
		if(Competition::orderBy('created_at', 'desc')->first()){
			
			return Competition::orderBy('created_at', 'desc')->first()->status;
			
		}
		
		return 0;
		
	}
	
	public static function competitionEndDate(){
		
		$competition = Competition::where('status', '<>', 0)->orderBy('created_at', 'desc')->first();
		
		if($competition){
			
			return $competition->end_date;
			
		}
		
	}

	public static function competitionExists(){
		
		if(count(Competition::where('status', 0)->first()) > 0) {
			
			return 1;
			
		}
		
		return 0;
		
	}
	
	public static function county($county = "all"){
				
		if($county == "all"){
			
			return self::$counties;
			
		}		
				
		return self::$counties[$county];
		
	}
	
	public static function searchTerm($request, $query) {

		if(($term = $request->get('srch_term'))) {
			$words = str_word_count($term);
			if($words > 1) {
				$term = str_word_count($term, 1, 'čćžšđ');
				$spacedTerm = str_word_count($request->get('srch_term'), 1, 'čćžšđ ');

				$query->whereIn('users.last_name', $term);
				$query->whereIn('users.name', $term);
				$query->orWhereIn('companies.name', $spacedTerm);

			} else {
				$term = str_replace(' ', '', $term);
				$query->orWhere('users.name', 'like', '%'. $term . '%');
				$query->orWhere('users.last_name', 'like', '%'. $term. '%');
				$query->orWhere('companies.name', 'like', '%'. $term . '%');
			}
                   
        	}
	}

}
