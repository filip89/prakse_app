<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function collegeMentor() {

    	return $this->belongsToMany('App/CollegeMentor');
    }
}
