<?php
class Press_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }


	
	public function getAll(){
		$q = $this->db->select('id,name,slug,theDate,tagline,thumbnail')
					  ->where('isActive', 1)
					  ->order_by("theDate",'desc')	
					  ->get("press_releases");	
		
		$Results = $q->result_array();		
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i]["year"] = date("Y",strtotime($Results[$i]["theDate"]));	
			$Results[$i]["files"] = $this->getPressFiles($Results[$i]["id"]);
		}		
		return $Results;

	}
	
	

	
	public function getPressDetail($slug){
		$q = $this->db->select('id,name,slug,theDate,tagline,description_A,description_B,thumbnail')
					  ->where('isActive', 1)
					  ->where('slug', $slug)
					  ->order_by("theDate",'desc')	
					  ->get("press_releases");	
		
		$Results = $q->row();		
		
		return $Results;

	}
	
	
	public function getHomepageNews(){
		$q = $this->db->select('label,headline,copy,image,link,link_text,image_parameters')
					  ->where('isActive', 1)
					  ->get("homepage_block");	
		
		$Results = $q->result_array();				
		return $Results;

	}
	
	
	
	
	// getPressFiles() -- list all of the downloadable files for a press release
	public function getPressFiles($id,$tablename='press_releases'){
		$q = $this->db->select('filepath,filesize,file_type,file_name')
					   ->where('isActive', 1)
					   ->where('tablename', $tablename)
					   ->where('reference_id', $id)
					   ->order_by('theOrder','asc')	
					   ->get("newsroom_downloads");
		 
		$Results = $q->result_array();

		return $Results;

	}
	

	
	
	public function getImages($id,$tablename='press_releases',$limit = NULL){
		if($limit) $this->db->limit($limit);
		
		$q = $this->db->select('*')
					   ->where('isActive', 1)
					   ->where('tablename', $tablename)
					   ->where('table_reference', $id)
					   ->order_by('theOrder','asc')	
					   ->get("newsroom_images");		 
		$Results = $q->result_array();	

		return $Results;
	}
	
	public function getFirstPressImage($id){
		$images = $this->getImages($id,'press_releases',1);
		if(count($images) == 0) return NULL;		
		return $images[0]['image_medium'];
		
	}
	
	public function getAssociatedProducts($id,$tablename='press_releases'){
		$output = array();
		
		$q = $this->db->select('item_type,item_id')
					   ->where('tablename', $tablename)
					   ->where('table_reference', $id)
					   ->order_by('theOrder','asc')	
					   ->get("newsroom_associated_products n");		 
		$Results = $q->result_array();
		
		for($i=0; $i<=(count($Results)-1); $i++){
			
			// category
			if($Results[$i]["item_type"] == "category"){
				$q2 = $this->db->select("cat_name AS 'name', slug")
						 	   ->where('cat_id', $Results[$i]["item_id"])
						 	   ->get("product_categories");
			} 
			 
			// default to 'product'
			else { 
				$q2 = $this->db->select("product_name AS 'name', slug")
						 	   ->where('product_id', $Results[$i]["item_id"])
						 	   ->where('isActive',1)
						 	   ->get("products");
			}
			array_push($output,$q2->row());
			   
		}	
		
		return $output;
	}

	
	
}