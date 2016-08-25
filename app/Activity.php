<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function applics() {

    	return $this->belongsTo('App\Applic');
    	
    }
}
