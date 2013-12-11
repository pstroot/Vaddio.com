<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intranet extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('authorization');
	}
	
	public function index(){
		set_title("Intranet");
		
		$data['bodyClass'] = "intranet";
		$content = array();
		$data['content'] = $this->load->view('intranet_view',  $content, true);
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	
	
		
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */