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
    
}
