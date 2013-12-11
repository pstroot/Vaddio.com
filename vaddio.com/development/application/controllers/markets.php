<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Markets extends MX_Controller {

	public function __construct() {
        parent::__construct(); 		
		$this->output->css("/css/markets.css");
		//$this->load->model('markets_model');			
	}

	public function index(){
		
		set_title("Markets");
		//set_keywords("keywords go here");
		//set_metadescription(strip_tags($category_data->description));
		
		$this->load->model('markets_model');	
		$content["markets"] = $this->markets_model->getMarkets();
		
		$data['bodyClass'] = "markets";
		$data['content'] = $this->load->view('markets_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}

	public function marketDetail($slug){
		$this->load->model('markets_model');	
		$this->load->model('doc_library_model');	
		$content["slug"] = $slug;
		
		$content["markets"] = $this->markets_model->getMarkets($slug);
		if(count($content["markets"]) == 0){
			log_message('error', 'CUSTOM: Could not find market for slug = "'.$slug.'" at '.current_url());
			set_title("Market Not Found");
			$content["slug_not_found"] = true;
			$content["marketDetail"]["name"] = "Market Not Found";
		} else {
			$content["marketDetail"] = $content["markets"][0];
			
			$content["videos"] = $this->markets_model->getMarketVideos($content["marketDetail"]["id"]);
			$content["documents"] = $this->markets_model->getMarketDocuments($content["marketDetail"]["id"]);
			$content["press"] = $this->markets_model->getMarketPress($content["marketDetail"]["id"]);
			$content["catalog"] = $this->doc_library_model->getDocLibraryPlacement('Markets Product Catalog');
		
			set_title($content["marketDetail"]["name"] . " Market");
			//set_keywords("keywords go here");
			set_metadescription(str_replace("\n","",str_replace("\r","",strip_tags($content["marketDetail"]["description"]))));
		
		}
		$data['bodyClass'] = "market-detail market-detail-" . $slug;
		$data['content'] = $this->load->view('market_detail_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}
	
}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */