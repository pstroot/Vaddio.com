<?php     
class Depreciated_browser_notification extends MX_Controller {
  

	public $autoload = array(
        //'helpers'   => array('url', 'form'),
        //'libraries' => array('javascript'),
    );
	

	 public function __construct() {
        parent::__construct();   
    }
	
	public function index() {		
		$this->load->view('Depreciated_browser_notification_view');
	}
	
	


	
	
	

}