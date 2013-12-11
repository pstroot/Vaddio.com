<?php
class Careers_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getAll(){		  

		$q = $this->db->select('slug,title,location')
					  ->where('isActive', 1)
					  ->where('posted_date <= NOW()')
					  ->order_by("theOrder")	
					  ->get("careers");	
		$Results = $q->result_array();	
		return $Results;
	}

	public function getOne($slug){		  
		$q = $this->db->select('title,location,department,description,footer,posted_date,contact')
					  ->where('isActive', 1)
					  ->where('slug', $slug)	
					  ->get("careers");	
		$Results = $q->row();	
		return $Results;
	}
	
}