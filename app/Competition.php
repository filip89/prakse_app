<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
	//
	
	public function internships() {

    	return $this->hasMany('App\Internship');
    	
    }
	
	public static function previous(){
		
		return self::where('status', 0)->orderBy('created_at', 'desc')->first();
		
	}
	
	public static function current(){
		
		if(self::where('status', '<>', 0)->first()){
			
			return self::where('status', '<>', 0)->first();
			
		}
		
	}
	
}
