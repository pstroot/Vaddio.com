<?php

class Content_model extends CI_Model {
	

	 public function __construct() {
        parent::__construct();   
    }

	
	public function getContent($id){
		// NOTE: If we do multiple levels of permissions, it should be retrieved here from the users table. It would then be set in the userdata session.
		$q = $this->db->select('content_value')
					  ->where('content_name',$id)
					  ->limit('1')
					  ->get('content');
		if($q->num_rows() == 0) return false;
		$output = $q->row();
		return $output->content_value;			
	}
	
	public function getContact($id){
		// NOTE: If we do multiple levels of permissions, it should be retrieved here from the users table. It would then be set in the userdata session.
		$q = $this->db->select('value')
					  ->where('name',$id)
					  ->limit('1')
					  ->get('contact');
		if($q->num_rows() == 0) return false;
		$output = $q->row();
		return $output->value;			
	}
	
	
	
	
	
}