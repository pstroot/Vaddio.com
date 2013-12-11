<?php
class Demos_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
    }

	public function getRooms(){		
		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->order_by("theOrder")	
					  ->get("demo_rooms");	
			
		$Results = $q->result_array();
		
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i]["products"] = $this->getRoomProducts($Results[$i]['room_id']);	 
		}		
		
		return $Results;
	}
	
	
	public function getRoomsByIDs($idArray){	
		$search = array();
		foreach($idArray as $id){
			array_push($search,'room_id = ' . $id);
		}
		$searchString = implode(" OR ",$search);
		
		$q = $this->db->select('room_id,calendar_id,room_name')
					  ->where('isActive', 1)
					  ->where($searchString)
					  ->order_by("theOrder")	
					  ->get("demo_rooms");	
			
		$Results = $q->result_array();		
		return $Results;
	}
	
	
	
	public function getRoomProducts($room_id){
			
		$q = $this->db->select('s.system_id, s.system_name, s.system_name_sp')
					  ->join('demo_systems s', 'm.system_id = s.system_id', 'left')
					  ->where('m.room_id', $room_id)
					  ->where('s.isActive', 1)
					  ->order_by("s.theOrder")	
					  ->get("demo_room_system_matches m");	
			
		$Results = $q->result_array();	
		return $Results;
	}
	
}