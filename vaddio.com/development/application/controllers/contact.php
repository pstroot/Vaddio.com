<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		set_title("Contact Us");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		
		$this->output->css('/css/contact.css');

		$this->load->model('contact_model');			
				
		$content['phone'] = $this->contact_model->getItem("Phone");
		$content['tollfree'] = $this->contact_model->getItem("Toll Free");
		$content['fax'] = $this->contact_model->getItem("Fax");
		$content['support_email'] = $this->contact_model->getItem("Support Email");
		$content['address'] = $this->contact_model->getItem("address");
		$content['address2'] = $this->contact_model->getItem("address2");
		$content['city'] = $this->contact_model->getItem("city");
		$content['state'] = $this->contact_model->getItem("state");
		$content['zip'] = $this->contact_model->getItem("zip");		
		
		$data['bodyClass'] = "contact";
		$data['content'] = $this->load->view('contact_view', $content, true);
			
		$this->load->view('templates/main_template', $data);	
	}

	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */