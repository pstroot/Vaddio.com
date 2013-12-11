<?php
class Casestudies_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getCategories($includeFiles = true){

		$q = $this->db->select('cat_id,name')
					  ->where('isActive', 1)
					  ->order_by("theOrder",'asc')	
					  ->get("case_studies_categories");	
		
		$Results = $q->result_array();
		
		//$this->getActiveLanguageResults(
		for($i=0; $i<=(count($Results)-1); $i++){
			if($includeFiles){
				$Results[$i]["press"] = $this->getPressReleaseByCaseStudyCategory($Results[$i]["cat_id"]);
			}
		}		
		return $Results;

	}
	
	// getPressFiles() -- list all of the downloadable files for a press release
	public function getPressReleaseByCaseStudyCategory($cat_id){
		$q = $this->db->select('id,name,slug,theDate,thumbnail,tagline')
					  ->join('press_releases p','p.id = c.press_release_id')
					  ->where('p.isActive', 1)
					  ->where('c.cat_id', $cat_id)
					  ->order_by('c.theOrder','asc')	
					  ->get("case_studies c");
		 
		$Results = $q->result_array();
		
		for($i=0; $i<=(count($Results)-1); $i++){
			$this->load->model('press_model');	
			$Results[$i]["files"] = $this->press_model->getPressFiles($Results[$i]["id"]);
		}		
		return $Results;

	}

	
	
}