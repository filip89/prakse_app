<?php

namespace App;


class Utilities
{
	
    private static $academic_year = array('1. godina preddiplomskog', '2. godina preddiplomskog', '3. godina preddiplomskog', '1. godina diplomskog', '2. godina diplomskog');
	
	public static function academicYear($year){
		
		return self::$academic_year[$year - 1];
		
	}
}
