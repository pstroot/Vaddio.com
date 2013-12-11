<?php

class Accessories_model extends MY_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function hasAccessories($id){

		// ACCESSORIES THAT ARE NOT IN ANY CATEGORY
		 $q = $this->db->select('a.accessory_id')
					  ->where('a.parent_product',$id)
					  ->where('p.isActive',1)
					  ->join('products p','a.child_product = p.product_id','left')
					  ->get('product_accessories a');
		$Results = $q->result_array();	
		// YES, there are accessories in a blank category, so indicate taht there should be a generic accessory link somewhere on here.
       if($q->num_rows() > 0) return true;
		return false;		
	}
	public function getAccessories($id){

		// ACCESSORIES THAT ARE NOT IN ANY CATEGORY
		 $q = $this->db->select('p.slug, p.product_nbr, p.product_nbr_label, p.product_addtl_nbrs, p.product_name, p.product_thumb, p.product_summary')
					  ->where('a.parent_product',$id)
					  ->where('p.isActive',1)
					  ->where('p.isDiscontinued',0)
					  ->join('products p','a.child_product = p.product_id','left')
					  ->get('product_accessories a');
		$Results = $q->result_array();	
		// YES, there are accessories in a blank category, so indicate that there should be a generic accessory link somewhere on here.
      	for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]['product_number_full'] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"]);
		}
		
		return $Results;		
	}
	
	

	
	
	
}