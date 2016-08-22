<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applic extends Model
{
    public function academicYear() {

    	return $this->belongsTo('App\AcademicYear');
    	
    }

    public function activities() {

    	return $this->belongsToMany('App\Activity');
    	
    }

    public function user() {

    	return $this->belongsTo('App\User');
    	
    }
}
