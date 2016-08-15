<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    public function applic() {

    	return $this->belongsToMany('Apps/Applic');

    }
}
