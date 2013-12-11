<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certified_integrators extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 		
		$this->output->css("/css/certified_integrators.css");			
	}

	public function index(){
		set_title("Certified Tracking Integrators");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$content = array();
		$this->load->model('certified_integrators_model');	
		$content["integrators"] = $this->certified_integrators_model->getAll();

		$data['bodyClass'] = "certified-integrators";
		$data['content'] = $this->load->view('certified_integrators_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}

	
	
}

/* End of file Certified_integrators.php */
/* Location: ./application/controllers/Certified_integrators.php */