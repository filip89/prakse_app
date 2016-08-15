<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applic extends Model
{
    public function academicYear() {

    	return $this->belongsToMany('Apps/AcademicYear');
    	
    }

    public function activity() {

    	return $this->belongsToMany('Apps/Activity');
    	
    }

    public function user() {

    	return $this->belongsTo('Apps/User');
    	
    }
}
