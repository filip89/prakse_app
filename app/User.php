<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name', 'last_name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function intern_mentor() {
		
		return $this->hasOne('App\InternMentor');
	
	}
	
	public function college_mentor() {
		
		return $this->hasOne('App\CollegeMentor');
	
	}
	
	public function applic() {
		
		return $this->hasOne('App\Applic', 'student_id');
	
	}
	
	//for student	
	public function internship() {
		
		return $this->hasOne('App\Internship', 'student_id');
		
	}
	
	//for mentors
	public function internships() {
		
		if($this->role == "intern_mentor"){
			
			return $this->hasMany('App\Internship', 'intern_mentor_id');
			
		}
		elseif($this->role == "college_mentor"){
			
			return $this->hasMany('App\Internship', 'college_mentor_id');
			
		}
	
	}
	
	/*
	public function i_mentor_internships() {
		
		return $this->hasMany('App\Internship', 'intern_mentor_id');
	
	}
	
	public function c_mentor_internships() {
		
		return $this->hasMany('App\Internship', 'college_mentor_id');
	
	}
	
	public function a_mentor_internships() {
		
		return $this->hasMany('App\Internship', 'applied_mentor_id');
	
	}
	*/
	
}
