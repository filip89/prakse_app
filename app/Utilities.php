<?php

namespace App;


class Utilities
{
	
   	private static $academic_year = array('1. godina preddiplomskog', '2. godina preddiplomskog', '3. godina preddiplomskog', '1. godina diplomskog', '2. godina diplomskog');
	
	private static $course = array('Financijski menadžment', 'Marketing', 'Menadžment', 'Poduzetništvo', 'Poslovna informatika');
	
	private static $desired_month = array(6 => 'Lipanj', 7 => 'srpanj', 8 => 'Kolovoz', 9 => 'Rujan');
	
	private static $activity = array('a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10');
	
	public static function academicYear($year){
		
		return self::$academic_year[$year - 1];
		
	}
	
	public static function course($course){
		
		return self::$course[$course - 1];
		
	}
	
	public static function desiredMonth($month){
		
		return self::$desired_month[$month];
		
	}
	
	public static function activity($num){
		
		return self::$activity[$num];
		
	}

}
