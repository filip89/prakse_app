<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
	//
	
	public function internships() {

    	return $this->hasMany('App\Internship');
    	
    }
	
}
