<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 
		$this->output->css("/css/partners.css");				
	}

	public function index(){
		set_title("Technology Partners");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->model('partners_model');	
		$content["partners"] = $this->partners_model->getAll();
		
		$data['bodyClass'] = "partners";
		$data['content'] = $this->load->view('partners_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	
	
}

/* End of file partners.php */
/* Location: ./application/controllers/partners.php */