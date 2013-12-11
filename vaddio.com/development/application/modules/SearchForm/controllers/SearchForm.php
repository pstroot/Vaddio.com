<?php     
class SearchForm extends MX_Controller {
  
	 public function __construct() {
        parent::__construct();   
		$this->output->css("/css/footer.css");
    }
	
	function index($showSubmitButton = false) {	
		$data=array();
		//$this->load->model('search_model');		
		//$data["product_categories"] = $this->search_model->getChildCategories(NULL, false);
		$searchString = end($this->uri->segments);
		if(count($this->uri->segments) > 0 && $this->uri->segments[1] == "search"){
			$data['searchString'] = urldecode($searchString);
		} else {
			$data['searchString'] = "";
		}
		$data['showSubmitButton'] = $showSubmitButton;
		$this->load->view('SearchForm_view',$data);			
	}

}