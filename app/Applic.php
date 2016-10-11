<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applic extends Model
{

    public function activities() {

    	return $this->hasMany('App\Activity');
    	
    }
	
	public function internship() {

    	return $this->hasOne('App\Internship');
    	
    }
	
	public function confirmedInternship() {
		
		if($this->internship && $this->internship->confirmation_admin == 1 && $this->internship->confirmation_student == 1){
			
			return $this->internship;
			
		}
    	
    	
    }

    public function student() {

    	return $this->belongsTo('App\User');
    	
    }
	
	public function competition() {

    	return $this->belongsTo('App\Competition');
    	
    }
    
}
