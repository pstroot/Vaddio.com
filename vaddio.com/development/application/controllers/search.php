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
		$content["googleResults"] = $this->search_model->search_google($search_for);
		$content['searchTermArray'] = $this->search_model->searchstring_to_array($search_for);
		$content['documents'] =  $this->search_model->search_downloads($search_for);
		
		// For Google Search
		$content['products'] = $content["googleResults"]["product"];
		$content['categories'] = $content["googleResults"]["category"];
		$content['videos'] = $content["googleResults"]["videos"];
		$content['press'] = $content["googleResults"]["press"];
		$content['caseStudies'] = $content["googleResults"]["case-studies"];
			
		set_title("Search Results for \"".urldecode($search_for)."\"");
		
		$content["searchFor"] = urldecode($search_for);
		$content["search_description"] = '"' . implode('" and "',$content['searchTermArray']) . '"';
		
		$data['bodyClass'] = "search";
		$data['content'] = $this->load->view('search_view', $content, true);
		$this->load->view('templates/main_template', $data);	
	}

	
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */