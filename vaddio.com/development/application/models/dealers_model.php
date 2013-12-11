<?php
class Dealers_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }


	
	public function getAll(){
		$q = $this->db->select('id,name,slug,description,image')
					  ->where('isActive', 1)
					  ->order_by("theOrder",'asc')	
					  ->get("partners");	
		
		$Results = $q->result_array();		
		return $Results;
	}
	
	
	public function getDocCategory($slug){
		$q = $this->db->select('category_id,cat_name,cat_description,slug')
					  ->where('slug', $slug)
					  ->where('isActive', 1)
					  ->get("partner_doc_categories");	
		
		$Results = $q->result_array();		
		return $Results;
	}
	
	
	public function getDocSubcategories($id){	
		$q = $this->db->select('category_id,cat_name,cat_description,slug')
					  ->where('parent_id', $id)
					  ->where('isActive', 1)
					  ->order_by("cat_order",'asc')	
					  ->get("partner_doc_categories");	
		
		$Results = $q->result_array();		
		return $Results;
	}
	
	public function getDocs($cat_id){	
		$q = $this->db->select('doc_id, name, tagline, summary, long_description, file_name, image_thumb, image_fullsize, link, link_text, price_list, price_dealer')
					  ->where('category_id', $cat_id)
					  ->where('isActive', 1)
					  ->order_by("doc_order",'asc')	
					  ->get("partner_docs");	
	
		$Results = $q->result_array();		
		return $Results;
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["type"] 		= $this->displayDocumentType($Results[$i]["type"]);
			$Results[$i]["size"] 		= $this->formatFilesize($Results[$i]["size"]);
		}
	}
	
	
	
	
	
}