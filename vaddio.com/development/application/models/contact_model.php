<?php
class Contact_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getCategories(){
		return $this->getChildCategories(NULL);
	}
	
	
	public function getItem($whatToGet){
		$q = $this->db->select('value')
				  	  ->where('name', $whatToGet)
					  ->get("contact");	
		if($q->num_rows > 0){
			return $q->row()->value;
		}
			
		return false;
	}
	

	
	public function getCategoryDetail($slug){
		// NOTE: If we do multiple levels of permissions, it should be retrieved here from the users table. It would then be set in the userdata session.
		$q = $this->db->select('cat_id AS id, slug, cat_name AS name, cat_image AS image, cat_image_thumb AS image_thumb, cat_image_fullsize AS image_fullsize, cat_description AS description, show_certified_integrators')
					  ->where('slug',$slug)
					  ->limit('1')
					  ->get('product_categories');
					  
		if($q->num_rows > 0){
			return $q->row();
		}
		return false;		
	}
	
	
	
}