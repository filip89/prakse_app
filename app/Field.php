<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function collegeMentors() {

    	return $this->belongsToMany('App\CollegeMentor');
    }
}
