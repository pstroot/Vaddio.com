<?php
class Events_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getEvents($id = NULL,$count = NULL){		  
		if($count){
			$this->db->limit($count);
		}
		if($id){
			$this->db->where('event_id', $id);
		}
		$q = $this->db->select('event_id AS id,name,link,theDate,displaydate,location,details,thumbnail')
					  ->where('isActive', 1)
					  ->where('theDate > now()')
					  ->order_by("theDate",'asc')	
					  ->get("events");	
			
		$Results = $q->result_array();	
			
		return $Results;
	}
	
}