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
		
		return $this->hasOne('App\Applic');
	
	}
	
	
}
