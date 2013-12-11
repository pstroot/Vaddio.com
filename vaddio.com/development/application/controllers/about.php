<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		
		
		set_title("About");
		$this->output->css("/css/about.css");
		$content = array();
		$data['bodyClass'] = "about";
		$data['content'] = $this->load->view('about_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
		
	}

	public function press(){
		set_title("Press Releases");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->css("/css/press_casestudies_whitepapers.css");
		$this->load->model('press_model');	
		$content["press"] = $this->press_model->getAll();	
		
		// replace missing files with an FPO Image
		for($i=0; $i<=(count($content["press"])-1); $i++){				
			$thumb = $content["press"][$i]["thumbnail"];
			if(!is_file("application/document_library/newsroom/press_releases/" . $thumb)){
				$first_image = $this->press_model->getFirstPressImage($content["press"][$i]["id"]);
				if($first_image){
					$content["press"][$i]["thumbnail"] = $first_image;
				} else {
					$content["press"][$i]["thumbnail"] =  "FPO_press_release.jpg";
				}
				
				
				//
			}
		}		
		
		$data['bodyClass'] = "press";
		$data['content'] = $this->load->view('press_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	public function formatFilesize($filesize){
		if($filesize < 1048576){
				$filesize = (number_format($filesize/1024,0)) . "k";
		} else {
				$filesize = (number_format($filesize/1024/1024,2)) . "mb";
		}
		return $filesize;
	}
	
	public function pressDetail($slug){
		$this->output->css("/css/press_casestudies_whitepapers.css");
		$this->load->model('press_model');	
		$content = $this->press_model->getPressDetail($slug);
		if(count($content) == 0){
			log_message('error', 'CUSTOM: Could not find press with slug = "'.$slug.'" at '.current_url());
			$content["name"] = "Press Not Found";
			$content["tagline"] = "Could not find the press release with an ID of \"" . $slug . "\"";
			$content["slug_not_found"] = true;
			set_title("Press Not Found");
		} else {			
			$content->files 			 = $this->press_model->getPressFiles($content->id);	
			$content->images 			 = $this->press_model->getImages($content->id);	
			$content->associatedProducts = $this->press_model->getAssociatedProducts($content->id,'press_releases');
			
			
			for($i=0; $i<=(count($content->files)-1); $i++){		
				$content->files[$i]["filesize"] 	= $this->formatFilesize($content->files[$i]["filesize"]);
			}
			
						
			set_title($content->name);
			//set_keywords("keywords go here");
			set_metadescription($content->tagline);
		
		}
		$data['bodyClass'] = "press-detail";
		$data['content'] = $this->load->view('press_detail_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	public function casestudies(){
		set_title("Case Studies");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->css("/css/press_casestudies_whitepapers.css");
		$this->load->model('casestudies_model');	
		$content["categories"] = $this->casestudies_model->getCategories();
		
		// replace missing files with an FPO Image
		for($i=0; $i<=(count($content["categories"])-1); $i++){				
			for($ii=0; $ii<=(count($content["categories"][$i]["press"])-1); $ii++){	
				$thumb = $content["categories"][$i]["press"][$ii]["thumbnail"];
				if(!is_file("application/document_library/newsroom/press_releases/" . $thumb)){
					$content["categories"][$i]["press"][$ii]["thumbnail"] =  "FPO_case_study.jpg";
				}
			}
		}
			
			
		$data['bodyClass'] = "casestudies";
		$data['content'] = $this->load->view('casestudies_view', $content, true);
		$this->load->view('templates/main_template', $data);
	}
	
	public function whitepapers(){
		set_title("White Papers");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->css("/css/press_casestudies_whitepapers.css");
		$this->load->model('whitepapers_model');	
		$content["categories"] = $this->whitepapers_model->getCategories();
		
		// replace missing files with an FPO Image
		for($i=0; $i<=(count($content["categories"])-1); $i++){				
			for($ii=0; $ii<=(count($content["categories"][$i]["whitepapers"])-1); $ii++){	
				$thumb = $content["categories"][$i]["whitepapers"][$ii]["thumbnail"];
				if(!is_file("application/document_library/newsroom/white_papers/" . $thumb)){
					$content["categories"][$i]["whitepapers"][$ii]["thumbnail"] =  "FPO_white_paper.jpg";
				}
			}
		}
		
		$data['bodyClass'] = "whitepapers";
		$data['content'] = $this->load->view('whitepapers_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	public function events(){
		set_title("Events");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->css("/css/press_casestudies_whitepapers.css");
		$this->load->model('events_model');	
		$content["events"] = $this->events_model->getEvents();
		$data['bodyClass'] = "events";
		$data['content'] = $this->load->view('events_view', $content, true);
		$this->load->view('templates/main_template', $data);
	}
	
	public function promotions(){
		set_title("Promotions");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->css("/css/promotions.css");
		$data['bodyClass'] = "promotions";
		$data['content'] = $this->load->view('promotions_view', '', true);	
		$this->load->view('templates/main_template', $data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */