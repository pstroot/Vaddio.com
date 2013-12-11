<?php
class Certified_integrators_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getAll(){

		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->order_by('isUS DESC, location, company, lastname, firstname, theOrder')
					  ->get("authorized_dealers");	
		//echo $this->db->last_query();
		$Results = $q->result_array();			
		return $Results;
	}
	
	
	
}