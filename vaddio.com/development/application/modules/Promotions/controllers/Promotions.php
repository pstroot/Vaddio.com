<?php     
class Promotions extends MX_Controller {

	 public function __construct() {
        parent::__construct();   
    }
	
	function index() {	
		$data = array();		
		$this->load->view('Promotions_view',$data);			
	}

}