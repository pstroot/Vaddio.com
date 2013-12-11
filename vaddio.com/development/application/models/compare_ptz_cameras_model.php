<?php
class Compare_PTZ_Cameras_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getAll(){	
		$productArray = array();
		$rows = $this->getRows();
		
		$q = $this->db->select('id,thumbnail,hd_or_sd,name')
					  ->where('isActive', 1)
					  ->order_by('theOrder')
					  ->get("comparison_chart");	
		$Results = $q->result_array();	
		
		for($i = 0; $i < count($Results); $i++){
			$Results[$i]["data"] = $this->getComparisonValueArray($Results[$i]["id"],$rows);
		}
		
		return $Results;
	}
	
	
	public function getRows(){
		$q = $this->db->select('row_id,row_name')
					  ->where('isActive', 1)
					  ->order_by('theOrder')
					  ->get("comparison_rows");	
					  
		$Results = $q->result_array();			
		return $Results;			
	}
	
	
	public function getComparisonValueArray($id,$rows = NULL){
		//if(!$rows) $rows = $this->getRows();
	
		$itemData = array();
		foreach($rows as $row){
			$thisRowID = $row["row_id"];	
			
			$q2 = $this->db->select('*')
				  ->where('row_id', $thisRowID)
				  ->where('chart_id', $id)
				  ->get("comparison_values");
			$Results2 = $q2->result_array();
			foreach($Results2 as $r2){
				$itemData["row_" . $thisRowID] = $r2["value"];	
			}
		}
		return $itemData; 	
	}
	
	
	
}