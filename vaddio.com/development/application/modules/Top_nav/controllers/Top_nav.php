<?php     
class Top_nav extends MX_Controller {

	 public function __construct() {
        parent::__construct();   
		
		/* ALL TOP NAV JAVASCRIPT IS INCLUDED IN js/global.js */
		//$this->output->javascript("/js/nav.js");
		$this->output->css("/css/topnav.css");
    }
	
	function index() {	
		
		$this->load->model('category_model');
		$data["top_categories"] = $this->category_model->getChildCategories(NULL, false);
		
		$this->load->model('markets_model');	
		$data["markets"] = $this->markets_model->getMarkets();
		
		
		$this->load->model('videos_model');
		$data["featured_video"] = $this->videos_model->getFeaturedVideo();
		$data["recent_videos"]  = $this->videos_model->getRecentVideos(5);
		
		$this->load->view('Top_nav_view',$data);			
	}
	
	

}