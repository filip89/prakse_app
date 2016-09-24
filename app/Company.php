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
		'spots',
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
		
		$current_date = date('Y-m-d h:i:s', strtotime('-6 months'));
		
		if(count($this->internships()->where('status', 0)->where('start_date', '>', strtotime('-6 months'))->where('confirmation_admin', 1)->where('confirmation_student', 1)->get()) > 0)
		
		return $this->internships()->where('status', 0)->where('start_date', '>', strtotime('-6 months'))->where('confirmation_admin', 1)->where('confirmation_student', 1)->get();
		
	}
	
}
