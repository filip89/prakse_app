<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    public function company() {

    	return $this->belongsToMany('Apps/Company');
    	
    }

    public function internMentor() {

    	return $this->belongsTo('Apps/InternMentor');
    	
    }

    public function collegeMentor() {

    	return $this->belongsTo('Apps/CollegeMentor');
    	
    }
}
