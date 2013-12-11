<?php

class Training_model extends CI_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getClassInfo($class_id){		
		$q = $this->db->select('c.*')
					  ->where('c.class_id',$class_id)
					  ->limit(1)
					  ->get('classes c');
		$Results = $q->result_array();
		return $Results;		
	}
	
	
	public function getClassSessions($class_id=NULL,$session_id = NULL){
		if($class_id){
			 $this->db->where('s.class_id',$class_id);
			 $this->db->where('session_start_date >= now()');
		}
		if($session_id){
			$this->db->where('s.session_id',$session_id);
			$this->db->limit(1);			
		}
		
		$q = $this->db->select('*')
					  ->where('s.isActive',1)
					   ->join('classes c','c.class_id = s.class_id','left')
					  ->order_by('s.session_start_date, s.session_start_time, s.session_end_date, s.session_end_time')
					  ->get('class_sessions s');
					 // print $this->db->last_query();
		$Results = $q->result_array();		
			
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i] = $this->calculateSessionDetails($Results[$i]);
						
		}	
		
				
		if($session_id){
			return $Results[0];			
		}
		return $Results;
		
	}
	
	public function registerPerson($data){
		if(	$this->db->insert('class_registration', $data)) {
			return $this->db->insert_id();
		} else {
			return false;	
		}
	}
	
	public function getRegistrationDetails($registration_id){
		$q = $this->db->select('cl.*, s.*, r.*')
					  ->where('r.registration_id',$registration_id)
					   ->join('class_sessions s','s.session_id = r.session_id','left')
					   ->join('classes cl','cl.class_id = s.class_id','left')
					   ->LIMIT(1)
					  ->get('class_registration r');
		$Results = $q->row();	

		if(count($Results) == 0) return false;
		
		$Results->displayDate = $this->formatSessionDate($Results->session_start_date,$Results->session_start_time,$Results->session_end_date,$Results->session_end_time);
		$Results->full_name = $Results->firstname . " " . $Results->lastname;		
		return $Results;
}

	
	
	public function formatSessionDate($session_start_date,$session_start_time,$session_end_date,$session_end_time){
		//$displayDate = date("l, F j, Y",strtotime($startDate));
		$timezone = "Central Time (North America)";
		
		$startTimeExists = ($session_start_time != "" && $session_start_time != "00:00:00") ? true : false;
		$endDateExists = ($session_end_date != "" && $session_end_date != "0000-00-00" && ($session_start_date != $session_end_date)) ? true : false;
		$endTimeExists = ($session_end_time != "" && $session_end_time != "00:00:00") ? true : false;
		
		$displayDate = date("l, F j",strtotime($session_start_date));
		
		if($startTimeExists){
			$displayDate .= date(", g:i A",strtotime($session_start_time));
		}
		
		if($endDateExists || $endTimeExists){
			$displayDate .= " - " ;
		}
		
		if($endDateExists){
			$displayDate .= date("l, F j",strtotime($session_end_date));
		}
		if($endTimeExists){		
			if($endDateExists){
				$displayDate .= ", " ;
			}
			$displayDate .= date("g:i A",strtotime($session_end_time));
		}
		if(trim($timezone) != "" && ($startTimeExists  || $endTimeExists)) $displayDate .= " (" . $timezone . ")";
		return $displayDate;
	}
	
	
	public function calculateSessionDetails($sessionArr){
		if(!isset($sessionArr["max_participants"])) die("max_participants must be passed into the array for getSessionData()<BR>-> Training_model.php");
		if(!isset($sessionArr["registration_cutoff_days"])) die("registration_cutoff_days must be passed into the array for getSessionData()<BR>-> Training_model.php");
			
		$sessionArr["closed"] = false;
		
		// Check to see if the maximum registrants has been reached
		if($sessionArr["max_participants"] > 0){
			
			$q = $this->db->select('registration_id')
					  ->where('session_id',$sessionArr["session_id"])
					  ->get('class_registration');
			//$Results = $q->result_array();		
			$sessionArr["total_participants"] = $q->num_rows();;
			$sessionArr["spots_available"] = $sessionArr["max_participants"] - $sessionArr["total_participants"];
			if($sessionArr["spots_available"] <= 0)$sessionArr["closed"] = true;
		}
				

		if($sessionArr["registration_cutoff_days"] >= 0){
			$registration_close_unix = strtotime($sessionArr["session_start_date"] . " -" . $sessionArr["registration_cutoff_days"] . " days");
			$sessionArr["registration_close_date"] = date("Y-m-d",$registration_close_unix);
				
			$diff = $registration_close_unix - strtotime("now");		
			$days = ceil($diff  / (60*60*24));
	
			$sessionArr["days_left_to_register"] = $days;
			if($sessionArr["days_left_to_register"] < 0)$sessionArr["closed"] = true;
		}
		
		
		
		$closedReason = "";
		$isDisabled = "";	
			
		if($sessionArr["force_closed"]){
			$isDisabled = "disabled";
			$closedReason = "Sorry, registration for this class has been closed";	
								
		} else if (isset($sessionArr["spots_available"]) && $sessionArr["spots_available"] <= 0){ 
			$isDisabled = "disabled";
			$closedReason = "Sorry, this class is full.";
			
		} else if (isset($sessionArr["registration_close_date"]) && $sessionArr["days_left_to_register"] < 0){
			$isDisabled = "disabled";
			$closedReason = "Sorry, registration for this class closed on " . date("F j",strtotime($sessionArr["registration_close_date"]));	
								
		} else if (isset($sessionArr["registration_close_date"]) && $sessionArr["days_left_to_register"] == 0){ 
			$detailMessage = "Registration will close at end of day today";
			
		} else if (isset($sessionArr["registration_close_date"]) && $sessionArr["days_left_to_register"] >= 0){ 							
			$detailMessage = "Registration will close in " . abs($sessionArr["days_left_to_register"]) . " days on ".date("F j",strtotime($sessionArr["registration_close_date"]));
		
		} else {
			$detailMessage = $sessionArr["spots_available"] . " of " . $sessionArr["max_participants"]. " spots still available";
			
		}
					
		$sessionArr["displayDate"] = $this->formatSessionDate(
															trim($sessionArr['session_start_date']),
															trim($sessionArr['session_start_time']),
															trim($sessionArr['session_end_date']),
															trim($sessionArr['session_end_time'])
															);
		$sessionArr["closedReason"] = $closedReason;
		$sessionArr["isDisabled"] = $closedReason;
		

		return $sessionArr;

	}
	

	public function isUserRegistered($session_id,$email = NULL,$lastname = NULL,$firstname = NULL){
		
		if($firstname)	$this->db->where('email',trim($email));
		if($lastname)	$this->db->where('lastname',trim($lastname));	
		if($firstname)	$this->db->where('firstname',trim($firstname));

		
		$q = $this->db->select('*')
					  ->where('session_id',$session_id)
					  ->LIMIT(1)
					  ->get('class_registration');
		
		if($q->num_rows() > 0 ) 
			return true;
		else
			return false;
	}
					 
	
	
	
}