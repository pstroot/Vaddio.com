<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 				
	}

	public function index($search_for = NULL){
		set_title("Search");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		$content = array();	
		
		$this->output->javascript('/js/search.js');
		$this->output->javascript('/js/jquery/jquery.highlight.js');
		$this->output->css('/css/search.css');

		$this->load->model('search_model');			
		$content['searchTermArray'] = $this->search_model->searchstring_to_array($search_for);
		$content['products']  =  $this->search_model->search_products($search_for,"OR",false);
		$content['documents'] =  $this->search_model->search_downloads($search_for);
		$content['categories'] = $this->search_model->search_categories($search_for);
		$content['videos'] = 	 $this->search_model->search_videos($search_for);
			
		set_title("Search Results for \"".$search_for."\"");
		
		$content["searchFor"] = urldecode($search_for);
		$content["search_description"] = '"' . implode('" and "',$content['searchTermArray']) . '"';
		
		$data['bodyClass'] = "search";
		$data['content'] = $this->load->view('search_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}

	
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */