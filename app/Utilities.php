<?php

namespace App;

class Utilities
{
	
   	private static $academic_years = array('1. godina preddiplomskog', '2. godina preddiplomskog', '3. godina preddiplomskog', '1. godina diplomskog', '2. godina diplomskog');
	
	private static $courses = array('Financijski menadžment', 'Marketing', 'Menadžment', 'Poduzetništvo', 'Poslovna informatika');
	
	private static $desired_months = array(6 => 'Lipanj', 7 => 'Srpanj', 8 => 'Kolovoz', 9 => 'Rujan');
	
	private static $activities = array('Članstvo u studentskoj i/ili civilnim udrugama; rad u studentskoj organizaciji koja je registrirana ili upisana u upisnik studentskih organizacija.', 'Studentsko predstavljanje u sveučilišnim ili drugim tijelima relevantnim za sustav znanosti i visokog obrazovanja (Senat, Studentsko zbor, Smotra).', 'Rad na znanstvenom projektu; izlaganje na znanstvenom i/ili stručnom skupu; uređivanje studentskih, znanstvenih ili stručnih časopisa (glavni urednik, tajnik/tajnica, članovi uredništva).', 'Izlaganje ili sudjelovanje u organizaciji ljetnih škola, znanstvenih i/ili stručnih skupova.', 'Seminari/radionice (organizacija/sudjelovanje).', 'Sudjelovanje u Erasmus programu i/ili rd u inozemstvu tijekom studija.', 'Rad preko studentskog centra.', 'Demonstratura tijekom preddiplomskog i/ili diplomskog studija.', 'Rektorova i/ili dekanova nagrada.', 'Sudjelovanje u studentskim natjecanjima i ostvareno jedno od prva tri mjesta.');
	
	public static function academicYear($year){
		
		return self::$academic_years[$year - 1];
		
	}
	
	public static function course($course){
		
		if(!isset($course)){
			return;
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
			return;
		}
		
		return self::$activities[$num - 1];
		
	}
	
	public static function competitionStatus(){
		
		return Setting::orderBy('created_at', 'desc')->first()->status;
		
	}

}
