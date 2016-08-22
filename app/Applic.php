<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applic extends Model
{

    public function activities() {

    	return $this->belongsToMany('App\Activity');
    	
    }

    public function student() {

    	return $this->belongsTo('App\User');
    	
    }
    
}
