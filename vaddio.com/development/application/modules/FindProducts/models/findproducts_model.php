<?php

class FindProducts_model extends MY_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	
	function getProduct($id = NULL){
		$this->db->select('p.product_name, product_id, slug');
		$this->db->where('isActive', 1);
		$this->db->where('product_id', $id);
		$query = $this->db->get("products");	
		$Results = $query->result_array();
				
		return $Results;
	}
	
	function getProductList($cat_id = NULL){
		$this->db->select('p.product_name, p.product_id, p.slug');
		$this->db->where('p.isActive', 1);
		$this->db->where('p.product_name != ""');
		$this->db->order_by('p.product_name,p.product_order','asc');
		
		if($cat_id != NULL){			
			$this->db->join('product_category_matches m', 'm.product_id = p.product_id');
			$this->db->where('m.cat_id', $cat_id);		
		} 		
		$query = $this->db->get("products p");	
		$Results = $query->result_array();	

		return $Results;
	}
	
	
	
	function getCategoryAndChildrenArray($parent_id = NULL){
		return $this->getChildCategories($parent_id);
	}
	
	
	
	
	
	function getChildCategories($parent_id = NULL){
		$this->db->select('cat_name AS name, cat_id, slug');
		if ($parent_id != NULL){
			$this->db->where('cat_parent', $parent_id);
		} else {
			$this->db->where('cat_parent IS NULL');
		}
		$this->db->order_by('cat_order','asc');	
		$query = $this->db->get("product_categories");	
		$Results = $query->result_array();		
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["children"] = $this->getChildCategories($Results[$i]["cat_id"]);
			$Results[$i]["products"] = $this->getProductList($Results[$i]["cat_id"]);
		}
		
		return $Results;
	}
	

	
}