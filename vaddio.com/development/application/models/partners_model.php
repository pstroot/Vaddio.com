<?php
class Partners_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
    }

	
	public function getAll(){
		$q = $this->db->select('id,name,slug,description,image')
					  ->where('isActive', 1)
					  ->order_by("theOrder",'asc')	
					  ->get("partners");	
		
		$Results = $q->result_array();		
		return $Results;
	}
	

	
}