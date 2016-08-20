<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    public function applics() {

    	return $this->belongsToMany('Apps/Applic');

    }
}
