<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsroom extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		redirect('press');	
	}

	public function press(){
		$this->load->model('press_model');	
		$content["press"] = $this->press_model->getAll();
		$data['bodyClass'] = "press";
		$data['content'] = $this->load->view('press_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	
	public function casestudies(){
		$this->load->model('casestudies_model');	
		$content["categories"] = $this->casestudies_model->getCategories();
		$data['bodyClass'] = "casestudies";
		$data['content'] = $this->load->view('casestudies_view', $content, true);
		$this->load->view('templates/main_template', $data);
	}
	public function whitepapers(){
		$this->load->model('whitepapers_model');	
		$content["categories"] = $this->whitepapers_model->getCategories();
		$data['bodyClass'] = "whitepapers";
		$data['content'] = $this->load->view('whitepapers_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	public function events(){
		$this->load->model('events_model');	
		$content["events"] = $this->events_model->getEvents();
		$data['bodyClass'] = "events";
		$data['content'] = $this->load->view('events_view', $content, true);
		$this->load->view('templates/main_template', $data);
	}
	public function promotions(){
		$data['bodyClass'] = "promotions";
		$data['content'] = $this->load->view('promotions_view', '', true);	
		$this->load->view('templates/main_template', $data);
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */