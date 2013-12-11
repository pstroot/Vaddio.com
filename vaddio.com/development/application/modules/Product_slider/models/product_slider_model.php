<?php

class Product_slider_model extends MY_Model {
	

	 public function __construct() {
        parent::__construct();   
    }

	public function getProducts(){
		// the showProductNumbers function is in helpers/global_helper.php
		$query = $this->db->select('s.id, s.link, s.image, s.title, s.summary')
						  ->where('s.isActive', 1)
						  ->order_by('s.theOrder','asc')	
						  ->get("homepage_product_slider s");	
		$Results = $query->result_array();	
		
		return $Results;
	}
	

	
	
	
}