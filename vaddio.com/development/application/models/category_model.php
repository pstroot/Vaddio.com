<?php

class Category_model extends MY_Model {
	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getAll(){
		$query = $this->db->select('cat_id AS id, cat_name, slug')
				  ->order_by('cat_order','asc')
				  ->get("product_categories");	
		$Results = $query->result_array();		
		return $Results;
	}
	
	public function getCategories(){
		return $this->getChildCategories(NULL);
	}
	
	
	public function getChildCategories($parent_id = NULL, $recursive = TRUE){
		$this->db->select('cat_id AS id, cat_name,cat_description AS description,cat_image AS image, slug');
		if ($parent_id != NULL){
			$this->db->where('cat_parent', $parent_id);
		} else {
			$this->db->where('cat_parent IS NULL');
		}
		$this->db->order_by('cat_order','asc');	
		$query = $this->db->get("product_categories");	
		$Results = $query->result_array();
		
		
		//$this->getActiveLanguageResults(
		for($i=0; $i<=(count($Results)-1); $i++){
			if($recursive){		
				$Results[$i]["children"] = $this->getChildCategories($Results[$i]["id"]);
			}
		}
		return $Results;
	}
	

	
	public function getCategoryDetail($slug){
		// NOTE: If we do multiple levels of permissions, it should be retrieved here from the users table. It would then be set in the userdata session.
		$q = $this->db->select('cat_id AS id, slug, cat_name AS name, cat_image AS image, cat_image_thumb AS image_thumb, cat_image_fullsize AS image_fullsize, cat_description AS description, show_certified_integrators')
					  ->where('slug',$slug)
					  ->limit('1')
					  ->order_by('cat_name')
					  ->get('product_categories');
					  
		return $q->row();
		
		return false;		
	}
	
	
	
}