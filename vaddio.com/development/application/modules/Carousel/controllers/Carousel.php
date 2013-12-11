<?php     
class Carousel extends MX_Controller {
  

	public $autoload = array(
        //'helpers'   => array('url', 'form'),
        //'libraries' => array('javascript'),
    );
	

	 public function __construct() {
        parent::__construct();   
    }
	
	public function index() {		
		$this->output->css( base_url() . "css/carousel.css");
		$this->output->javascript( base_url() . "js/carousel.js");
		$this->load->view('Carousel_view');
	}
	
	


	
	
	

}