<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function internships() {

    	return $this->hasMany('App\Internship');
    	
    }

<<<<<<< HEAD
    public function intern_mentor() {
=======
    public function internMentors() {
>>>>>>> origin/master

    	return $this->hasMany('App\InternMentor');
    }
}
