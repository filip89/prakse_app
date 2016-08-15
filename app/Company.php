<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function internships() {

    	return $this->belongsToMany('Apps/Internship');
    	
    }

    public function internMentor() {

    	return $this->belongsTo('App/InternMentor');
    }
}
