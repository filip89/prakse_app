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
	
	public function profile() {
		
		if($this->role == "intern_mentor"){
			
			return $this->hasOne('App\InternMentor');
			
		}
		elseif($this->role == "college_mentor"){
			
			return $this->hasOne('App\CollegeMentor');
			
		}
	
	}
	
	public function competitionStatus() {
		
		$activeInternship = $this->internships()->where('status', '<>', 0)->first();
		
		if($activeInternship){
			
			if($activeInternship->confirmation_student == 1){
				
				return "Potvrđena praksa";
				
			}
			
			return "Izrađena praksa";
			
		}
		if(count($this->applics()->where('status', '<>', 0)->get()) > 0){
			
			return "Izrađena prijava";
			
		}
		
		return "Nema prijave";
		
	}
	
	public function activeInternship() {
			
		if(count($this->internships()->where('status', '<>', 0)->get()) > 0){
			
			return $this->internships()->where('status', '<>', 0)->first();
			
		}
		
		return false;		
		
	}
	
	public function confirmedInternship(){
		
		if(count($this->internships()->where('status', '<>', 0)->where('confirmation_student', 1)->get()) > 0){
			
			return true;
			
		}
		
		return false;
		
	}
	
	public function activeApplic() {
		
		if($this->role == 'student'){
		
			if(count($this->applics()->where('status', '<>', 0)->get()) > 0){
			
				return $this->applics()->where('status', '<>', 0)->first();
			
			}
		
			return false;
		}
	}
	
	public function applics() {
		
		if($this->role == "student"){
		
			return $this->hasMany('App\Applic', 'student_id');
		
		}
	
	}
	
	
	//for mentors
	public function internships() {
		
		if($this->role == "student"){
		
			return $this->hasMany('App\Internship', 'student_id');
		
		}
		
		if($this->role == "intern_mentor"){
			
			return $this->hasMany('App\Internship', 'intern_mentor_id');
			
		}
		elseif($this->role == "college_mentor"){
			
			return $this->hasMany('App\Internship', 'college_mentor_id');
			
		}
		
	}
	
}
