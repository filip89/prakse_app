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
	
	//check if user is admin
	public function isAdmin(){
		
		if($this->admin == 0) {
			return false;
		}
		elseif($this->admin == 1) {
			return true;
		}
	}
	
	/*
	public function intern_mentor() {
		
		return $this->hasOne('App\InternMentor');
	
	}
	
	public function college_mentor() {
		
		return $this->hasOne('App\CollegeMentor');
	
	}
	*/
	
	public function profile() {
		
		if($this->role == "intern_mentor"){
			
			return $this->hasOne('App\InternMentor');
			
		}
		elseif($this->role == "college_mentor"){
			
			return $this->hasOne('App\CollegeMentor');
			
		}
	
	}
	
	public function applic() {
		
		if($this->role == "student"){
		
			return $this->hasOne('App\Applic', 'student_id');
		
		}
	
	}
	
	//for student	
	public function internship() {
		
		if($this->role == "student"){
		
			return $this->hasOne('App\Internship', 'student_id');
		
		}
		
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
