<?php     
class Recaptcha extends MX_Controller {
	function index() {	
		$data=array();
		$this->load->helper('recaptchalib');
		$data["recaptcha_public_key"] = $this->config->item('recaptcha_public_key');			
		$this->load->view('Recaptcha_view',$data);			
	}
}