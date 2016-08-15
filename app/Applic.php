<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applic extends Model
{
    public function academicYears() {

    	return $this->belongsToMany('Apps/AcademicYear');
    	
    }

    public function activities() {

    	return $this->belongsToMany('Apps/Activity');
    	
    }

    public function user() {

    	return $this->belongsTo('Apps/User');
    	
    }
}
