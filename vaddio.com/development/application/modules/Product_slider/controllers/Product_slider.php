<?php     
class Product_slider extends MX_Controller {
  

	public $autoload = array(
        //'helpers'   => array('url', 'form'),
        //'libraries' => array('javascript'),
    );
	

	 public function __construct() {
        parent::__construct();   
    }
	
	public function index() {		
		$this->output->css( base_url() . "css/product_slider.css");
		$this->output->javascript( base_url() . "js/product_slider.js");
		
		
		$this->load->model('product_slider_model');	
		$data["products"] = $this->product_slider_model->getProducts();
		
		$this->load->view('Product_slider_view',$data);
	}
	
	


	
	
	

}