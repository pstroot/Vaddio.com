<?php     
class Partner_nav extends MX_Controller {
  


	 public function __construct() {
        parent::__construct();   
		$this->output->css("/css/partnernav.css");
    }
	
	function index() {
		if($this->authorization->is_logged_in()){
			$data = array();
			
			$this->load->model('dealers_model');	
			$data["categories"] = $this->dealers_model->getDocSubcategories(0);
		
			$this->load->view('Partner_nav_view',$data);
		}			
	}
	
	

}