<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_started extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 		
		$this->output->css("/css/get_started.css");			
	}

	public function index(){
		
		set_title("Certified Integrators");
		
		$content = array();
		$data['bodyClass'] = "get-started";
		$data['content'] = $this->load->view('get_started_view', $content, true);			
		$this->load->view('templates/main_template', $data);
		
	}
	
	
	public function certified_integrators(){
		set_title("Certified Tracking Integrators");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$content = array();
		$this->load->model('certified_integrators_model');	
		$content["integrators"] = $this->certified_integrators_model->getAll();
		
		// Bring NULL location integrators to the end of the list
		$content["integrators_null"] = array();
		foreach ($content["integrators"] as $i => $integrator) {
			if ($integrator["location"] == "NULL" || $integrator["location"] == "") {
				$content["integrators_null"][] = $integrator;
				unset($content["integrators"][$i]);
			}
		}

		$data['bodyClass'] = "certified-integrators";
		$data['content'] = $this->load->view('certified_integrators_view', $content, true);
		$this->load->view('templates/main_template', $data);	
	}
	
	public function premier_dealers(){
		set_title("VIP EasyUSB Integrators");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$content = array();
		$this->load->model('premier_dealers_model');	
		$content["premier_dealer_categories"] = $this->premier_dealers_model->get_all_by_cateogry();

		$data['bodyClass'] = "premier-dealers";
		$data['content'] = $this->load->view('premier_dealers_view', $content, true);			
		$this->load->view('templates/main_template', $data);
	}
	
	
}

/* End of file Certified_integrators.php */
/* Location: ./application/controllers/Certified_integrators.php */