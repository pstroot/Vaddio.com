<?php
class Markets_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getMarkets($slug = NULL,$count = NULL){		  
		if($count)	$this->db->limit($count);		
		if($slug)	{
			$this->db->where('slug', $slug);
			$this->db->select('id,image,description');
		}
		
		$q = $this->db->select('name,slug,thumbnail')
					  ->where('isActive', 1)
					  ->order_by('theOrder')
					  ->get("markets");	
		//echo $this->db->last_query();
		$Results = $q->result_array();			
		return $Results;
	}
	
	
	public function getMarketPress($id,$count = NULL){	
		if($count)	$this->db->limit($count);
		$q = $this->db->select('p.name,p.slug')
					  ->where('p.isActive', 1)
					  ->where('m.type', 'press')
					  ->where('market_id', $id)
					  ->order_by('m.theOrder')
					  ->join("markets_attachments m","m.lookup_id = p.id")
					  ->get("press_releases p");	
		$Results = $q->result_array();			
		return $Results;
	}
	
	
	public function getMarketVideos($id,$count = NULL){	
		if($count)	$this->db->limit($count);
		$q = $this->db->select('v.slug,v.video_name,v.video_thumbnail,v.video_summary')
					  ->where('v.isActive', 1)
					  ->where('m.type', 'video')
					  ->where('market_id', $id)
					  ->order_by('m.theOrder')
					  ->join("markets_attachments m","m.lookup_id = v.video_id")
					  ->get("product_videos v");	
		$Results = $q->result_array();			
		return $Results;
	}
	
	
	public function getMarketDocuments($id,$count = NULL){	
		if($count)	$this->db->limit($count);
		$q = $this->db->select('l.name,l.type,l.path,l.size')
					  ->where('l.isActive', 1)
					  ->where('m.type', 'document')
					  ->where('market_id', $id)
					  ->order_by('m.theOrder')
					  ->join("markets_attachments m","m.lookup_id = l.doc_id")
					  ->get("document_library l");	
		$Results = $q->result_array();	
		
		$this->load->model('doc_library_model');	
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["type"] 	= $this->doc_library_model->displayDocumentType($Results[$i]["type"]);
			$Results[$i]["size"] 	= $this->doc_library_model->formatFilesize($Results[$i]["size"]);
			$Results[$i]["path"] 	= $this->doc_library_model->filterDocPath($Results[$i]["path"]);
		}		
		return $Results;
	}
	
	
	
}