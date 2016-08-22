<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function internships() {

    	return $this->hasMany('App\Internship');
    	
    }

    public function intern_mentors() {

    	return $this->hasMany('App\InternMentor');
    }
}