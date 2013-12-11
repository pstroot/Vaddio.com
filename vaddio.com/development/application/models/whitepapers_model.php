<?php
class Whitepapers_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getCategories($includeFiles = true){
		$q = $this->db->select('cat_id,cat_name AS name')
					  ->where('isActive', 1)
					  ->order_by("cat_order",'asc')	
					  ->get("white_papers_categories");			
		$Results = $q->result_array();		
		//$this->getActiveLanguageResults(
		for($i=0; $i<=(count($Results)-1); $i++){
			if($includeFiles){
				$Results[$i]["whitepapers"] = $this->getResultsByCategory($Results[$i]["cat_id"]);
			}
		}		
		return $Results;
	}
	
	// getPressFiles() -- list all of the downloadable files for a press release
	public function getResultsByCategory($cat_id){
		$q = $this->db->select('white_paper_id AS id,name,description,thumbnail')
					  ->where('isActive', 1)
					  ->where('cat_id', $cat_id)
					  ->order_by('theOrder','asc')	
					  ->get("white_papers");
		 
		$Results = $q->result_array();
		
		for($i=0; $i<=(count($Results)-1); $i++){
			$this->load->model('press_model');	
			$Results[$i]["files"] = $this->press_model->getPressFiles($Results[$i]["id"],'white_papers');
		}		
		return $Results;

	}

	
	
}