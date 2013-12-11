<?php
class Premier_dealers_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getAll(){

		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->where('isApproved', 1)
					  ->order_by('name')
					  ->get("premier_dealers_categories");	

		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->where('isApproved', 1)
					  ->order_by('name')
					  ->get("premier_dealers");	
		//echo $this->db->last_query();
		$Results = $q->result_array();			
		return $Results;
	}
	
	public function get_all_by_cateogry(){
		
		
		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->order_by('theOrder')
					  ->get("premier_dealers_categories");	

		$Results = $q->result_array();		
		
		for($i=0; $i < count($Results); $i++){
			$q2 = $this->db->select('*')
					  ->where('isActive', 1)
					  ->where('isApproved', 1)
					  ->where('cat_id', $Results[$i]["cat_id"])
					  ->order_by('name')
					  ->get("premier_dealers");	

			$Results[$i]["dealers"] = $q2->result_array();	
		}
		
		return $Results;
		
	}
	
	
	
}