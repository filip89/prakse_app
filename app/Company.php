<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	
	protected $fillable = [
		'name',
		'email',
		'phone',
		'residence',
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
	
	public function recentInternships(){
		
		return $this->internships()->where('confirmation_admin', 1)->where('confirmation_student', 1)->get();
		
	}
	
}
