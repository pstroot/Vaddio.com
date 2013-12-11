<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -  
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	  
	 public function __construct() {
        parent::__construct();   
        //$this->lang->load("home");
    }

	public function index()
	{	
		set_title("Vaddio &mdash; The Art of Easy",true);
		set_keywords("keywords go here");
		set_metadescription("Vaddio brings sophisticated PTZ camera technology within everyone's reach.");
		
		$this->output->css		  ( base_url() . "css/homepage.css");
		$this->output->javascript ( base_url() . "js/jquery/jquery.ui.touch-punch.min.js");
		$this->output->javascript ( base_url() . "js/homepage_product_slider.js");
		
		// fancybox for the "Compare PTZ Cameras button
		$this->output->javascript("/js/compare_ptz_cameras_popup.js");
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		
		$data['bodyClass'] = "home";
		
		$this->load->model('events_model');	
		$home_view_data["events"] = $this->events_model->getEvents(NULL,4);
		
		$this->load->model('videos_model');	
		$home_view_data["videos"] = $this->videos_model->getHomepageVideos();
		
		$this->load->model('markets_model');	
		$home_view_data["markets"] = $this->markets_model->getMarkets();
		
		$this->load->model('press_model');	
		$home_view_data["news"] = $this->press_model->getHomepageNews();
		
		$this->load->model('product_model');	
		$home_view_data["products"] = $this->product_model->getProductsForHomepage();
		
	
		$data['content'] = $this->load->view('home_view', $home_view_data, true);
		$this->load->view('templates/main_template', $data);	
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */