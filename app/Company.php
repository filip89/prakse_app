<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	
	use RecentInternshipsable;
	
	protected $fillable = [
		'name',
		'email',
		'phone',
		'residence',
		'spots',
		'field',
	];
	
    public function internships() {

    	return $this->hasMany('App\Internship');
    	
    }

    public function intern_mentors() {

    	return $this->hasMany('App\InternMentor');
    }

	public function spotsAvailable(){
		
		return $this->spots - count($this->internships()->where('status', 2)->get());
		
	}
	
}
