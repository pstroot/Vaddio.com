<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		set_title("Product Catalog");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		
		$this->output->css('/css/catalog.css');
		$data['bodyClass'] = "catalog";
		$content = array();
		$data['content'] = $this->load->view('catalog_view', $content, true);
			
		$this->load->view('templates/main_template', $data);	
	}

	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */