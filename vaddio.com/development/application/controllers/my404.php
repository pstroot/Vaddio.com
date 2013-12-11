<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my404 extends MX_Controller {

	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		
		set_title("404 Page Not Found");
		//set_keywords("keywords go here");
		//set_metadescription(strip_tags($category_data->description));
		
		
		
		$data['bodyClass'] = "my404";
		$data['content'] = $this->load->view('my404_view', '', true);	
		$this->load->view('templates/main_template', $data);	
	}

	
}

/* End of file my404.php */
/* Location: ./application/controllers/my404.php */