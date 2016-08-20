<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    public function applics() {

<<<<<<< HEAD
    	return $this->belongsToMany('Apps/Applic');
=======
    	return $this->belongsToMany('App\Applic');
>>>>>>> origin/master

    }
}
