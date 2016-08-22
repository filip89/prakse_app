<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollegeMentor extends Model
{
	//

	protected $fillable = [
		'user_id',
    ];
	
    public function user() {
		
		return $this->belongsTo('App\User');
	
	}

	public function fields() {

		return $this->belongsToMany('App\Field');

	}

	/*
	public function internships() {

		return $this->hasMany('App\Internship');
		
	}
	*/
}
