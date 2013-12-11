<?php

class Product_model extends MY_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getProducts($cat_id){
		// the showProductNumbers function is in helpers/global_helper.php
		$query = $this->db->select('p.product_id AS id, slug, product_name AS name,product_summary AS summary,product_nbr,product_nbr_label, product_addtl_nbrs, product_image AS image ')
						  ->join('product_category_matches m', 'm.product_id = p.product_id')
						  ->where('p.isActive', 1)
						  ->where('p.isDiscontinued', 0)
						  ->where('m.cat_id', $cat_id)
						  ->order_by('p.product_order','asc')	
						  ->get("products p");	
		$Results = $query->result_array();	
		
		

		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["systems"] = $this->getSystems($Results[$i]["id"]);		
			//$Results[$i]["children"] = $this->getChildCategories($Results[$i]["id"]);
			//$Results[$i]["products"] = $this->getProductList($Results[$i]["cat_id"]);
			$Results[$i]['product_number_full'] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"]);
		}
		
		return $Results;
	}
	
	public function getProductList($order_by = "p.product_order"){
		$query = $this->db->select('slug, product_name')
						  ->where('p.isActive', 1)
						  ->where('p.isDiscontinued', 0)
						  ->order_by($order_by)	
						  ->get("products p");	
		$Results = $query->result_array();	
		return $Results;
	}
	
	
	
	public function getProductsForHomepage(){
		$query = $this->db->select('p.product_id AS id, slug, product_name AS name, product_summary AS summary,product_nbr,product_nbr_label, product_addtl_nbrs, product_image AS image ')
						  ->where('p.isActive', 1)
						  ->where('p.isDiscontinued', 0)
						  ->order_by('p.product_order','RANDOM')	
						  ->limit(20)	
						  ->get("products p");	
		$Results = $query->result_array();	
		
		return $Results;
	}
	
	
	

	public function getProductDetail($slug){
		// the showProductNumbers function is in helpers/global_helper.php
		
		$q = $this->db->select('p.product_id AS id, p.slug, p.product_name AS name,p.product_description AS description, p.product_summary AS summary,c.cat_id AS thisCatID, c.slug AS thisCatSlug, product_image AS image,product_thumb,product_fullsizeimage,product_nbr,product_nbr_label,product_addtl_nbrs,isSystem,isDiscontinued,product_price,product_dealer_price,show_auth_dealers,show_ptz_camera_link')
					  ->join('product_category_matches m','m.product_id = p.product_id','left')
					  ->join('product_categories c','c.cat_id = m.cat_id','left')
					  ->where('p.slug',$slug)
					  ->limit('1')
					  ->get('products p');
		$Results = $q->result_array();
		if($q->num_rows() == 0) return false;
		$Results = $Results[0]; 
		if($Results){
			if($Results["isSystem"] == 1){
				$Results["parentSystems"] = $this->getParentSystems($Results["id"]);		
			}	
			return $Results;
		}
		//print $this->db->last_query();
		return false;		
	}
	
	
	
	
	public function getImages($id){
		$q = $this->db->select('image_medium, image_large, image_small, image_caption')
					  ->where('product_id',$id)
					  ->order_by('image_order')
					  ->get('product_images');
		
		$Results = $q->result_array();
		//print $this->db->last_query();
		return $Results;		
	}
	
	
	
	
	public function getSystems($id){
		$q = $this->db->select('*')		
					  ->join('product_system_matches m','p.product_id = m.product_id','left')
					  ->where('m.system_id',$id)
					  ->where('p.isActive',1)
					  ->order_by('product_system_order, product_order','asc')
					  ->get('products p');
		$Results = $q->result_array();	
		for($i=0; $i<=(count($Results)-1); $i++){	
			$Results[$i]["product_number_full"] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"],false);	
		}
		return $Results;		
	}
	
	
	public function getSystemsIncludes($id){
		$q = $this->db->select('p.product_name, p.product_id, p.slug')		
					  ->join('product_systems s','p.product_id = s.product_id','left')
					  ->where('s.system_id',$id)
					  ->where('p.isActive',1)
					  ->order_by('product_system_order, product_order','asc')
					  ->get('products p');
		$Results = $q->result_array();	
		//for($i=0; $i<=(count($Results)-1); $i++){	
			//$Results[$i]["product_number_full"] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"],false);	
		//}
		return $Results;		
	}
	
	
	
	public function getParentSystems($id){
		
		$q = $this->db->select('p1.product_name, p1.product_id, p1.slug')
						  ->join('product_system_matches m','p1.product_id = m.system_id','left')
						  ->where('m.product_id',$id)
						  ->get('products p1');
		//$this->db->last_query();
		return $q->result_array();		
	}
	
	
	
	
	public function getRelatedProducts($id){
		$q = $this->db->select('slug, product_name AS name,product_thumb')
					  ->join('product_related r', 'r.child_product = p.product_id')
					  ->where('r.isActive',1)
					  ->where('p.isActive',1)
					  ->where('r.parent_product',$id)
					  ->order_by('related_order')
					  ->get('products p');
		
		$Results = $q->result_array();
		return $Results;
	}
	
	
	
	
	
	public function getProductSystems($id){
		// the showProductNumbers function is in helpers/global_helper.php
		
		$q = $this->db->select('*')
					  ->join('product_system_matches m', 'p.product_id = m.product_id', 'left')
					  ->where('p.isActive',1)
					  ->where('m.system_id',$id)
					  ->order_by('product_system_order, product_order')
					  ->get('products p');
		
		$Results = $q->result_array();
		
		for($i=0; $i<=(count($Results)-1); $i++){	
			$Results[$i]['product_number_full'] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"]);
		}
		
		return $Results;
	}
	
	
	
	
	public function getProductSpecs($id){		
		$q = $this->db->select('*')
					  ->where('product_id',$id)
					  ->order_by('spec_order')
					  ->get('product_specs');		
		$Results = $q->result_array();
		return $Results;
	}
	
	public function getProductFeatures($id){		
		$q = $this->db->select('*')
					  ->where('product_id',$id)
					  ->order_by('feature_order')
					  ->get('product_features');		
		$Results = $q->result_array();
		return $Results;
	}
	
	
	
	
	
	
	

	
	
	
}