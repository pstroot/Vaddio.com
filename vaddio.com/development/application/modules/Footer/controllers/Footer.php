<?php     
class Footer extends MX_Controller {
  
	 public function __construct() {
        parent::__construct();   
		$this->output->css("/css/footer.css");
    }
	
	function index() {	
		$data=array();
		//$this->load->model('category_model');		
		//$data["product_categories"] = $this->category_model->getChildCategories(NULL, false);
		$this->load->view('Footer_view',$data);			
	}

}