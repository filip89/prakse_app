<?php

namespace App;

//trait čisto da se nađe
trait RecentInternshipsable
{
	
	public function recentInternships(){
		
		$monthsAgo = date('Y-m-d h:i:s', strtotime('-6 months'));
		
		if(count($this->internships()->where('status', 0)->where('created_at', '>', $monthsAgo)->where('confirmation_admin', 1)->where('confirmation_student', 1)->get()) > 0)
		
		return $this->internships()->where('status', 0)->where('created_at', '>', $monthsAgo)->where('confirmation_admin', 1)->where('confirmation_student', 1)->get();
		
	}
	
}
