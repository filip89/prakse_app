<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public function company() {

    	return $this->belongsTo('App\Company');
    	
    }

    public function intern_mentor() {

    	return $this->belongsTo('App\User');
    	
    }

    public function college_mentor() {

    	return $this->belongsTo('App\User');
    	
    }

    public function student() {

    	return $this->belongsTo('App\User');
    	
    }
	public function competition() {

    	return $this->belongsTo('App\Competition');
    	
    }
	
	public function applic() {

    	return $this->belongsTo('App\Applic');
    	
    }
	
	public static function recent(){
		
		$lastSixMonths = strtotime('-6 months');
			
		return static::where('created_at', '>', $lastSixMonths)->where('confirmation_admin', "=", 1)->where('confirmation_student', "=", 1);
		
	}
    
}
