<?php
class Support_faq_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getFAQ($product_id){		  
		$q = $this->db->select('*')
					  ->where('product_id', $product_id)
					  ->order_by("theOrder")	
					  ->get("faq");	
		$Results = $q->result_array();	
		return $Results;
	}


	


	
}