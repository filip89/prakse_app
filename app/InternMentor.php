<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternMentor extends Model
{
	//
	
	protected $fillable = [
		'user_id',
    ];
	
    public function user() {
		
		return $this->belongsTo('App\User');
	
	}

	public function company() {

		return $this->belongsTo('App\Company');
		
	}
	
	/*
	public function internships() {

		return $this->hasMany('App\Internship');
		
	}
	*/
	
}
