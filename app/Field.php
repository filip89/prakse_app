<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function collegeMentors() {

<<<<<<< HEAD
    	return $this->belongsToMany('App/CollegeMentor');
=======
    	return $this->belongsToMany('App\CollegeMentor');
>>>>>>> origin/master
    }
}
