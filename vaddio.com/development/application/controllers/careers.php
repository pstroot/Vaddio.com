<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careers extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 	
			
		$this->load->model('content_model');
		$this->default_email = $this->content_model->getContent("Default Careers Email Address");	
				
	}


	public function index(){
		set_title("Careers");
		//set_keywords("keywords go here");
		set_metadescription(" With less than 100 employees, Vaddio is not a huge company by any means, but there is huge opportunity to make a significant impact within the organization and make a difference. Vaddio is growing and we would like you to be a part of our growth.");
		
		$this->output->css("/css/careers.css");
		$this->load->model('careers_model');	
		
		$content = array();	
				
		$content["contact_array"] = $this->parseEmailString($this->default_email);
		
		$content["careers"] = $this->careers_model->getAll();
		
		$data['bodyClass'] = "careers";
		$data['content'] = $this->load->view('careers_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}
	
	public function working_at_vaddio(){		
		set_title("Working at Vaddio");
		//set_keywords("keywords go here");
		//set_metadescription($content->tagline);
		
		$this->output->css("/css/careers.css");
		
		$content = array();			
		$content["contact_array"] = $this->parseEmailString($this->default_email);	
		
		$data['bodyClass'] = "careers-working";
		$data['content'] = $this->load->view('careers_working_at_vaddio_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}
	
	public function careerDetail($slug){
		$this->output->css("/css/careers.css");
		$this->load->model('careers_model');	
		
		$content = array();				
		$content = $this->careers_model->getOne($slug);
		
		
		if(count($content) == 0){
			log_message('error', 'CUSTOM: Could not find career with slug = "'.$slug.'" at '.current_url());
			$content["name"] = "Career Not Found";
			$content["title"] = "Could not find the career release with an ID of \"" . $slug . "\"";
			$content["slug_not_found"] = true;
			set_title("Career Not Found");
		} else {			
			if($content->contact == ""){
				$content->contact_array = $this->parseEmailString($this->default_email);	
			} else {
				$content->contact_array = $this->parseEmailString($content->contact);	
			}
			$content->footer = str_replace("{CONTACT}",$content->contact_array["contact_string"],$content->footer);
			
			$theTitle = $content->title;
			if(trim($content->location) != "") $theTitle .= ": " . $content->location;
			set_title($theTitle);
			//set_keywords("keywords go here");
			//set_metadescription($content->description);
		}
		$data['bodyClass'] = "career-detail";
		$data['content'] = $this->load->view('career_detail_view', $content, true);	
		$this->load->view('templates/main_template', $data);		
	}
	
	
	
	
	private function parseEmailString($input){
		$tempArray = array();
		$email_parts = explode("|",$input);	
		
		$tempArray["contact_email"] = trim($email_parts[0]);
		$tempArray["contact_string"] = "<a href='mailto:".$tempArray["contact_email"]."'>" . $tempArray["contact_email"] . "</a>";
		
		if(count($email_parts) > 1){
			$tempArray["contact_name"] = trim($email_parts[1]);
			$tempArray["contact_string"] = $tempArray["contact_name"] . " at " . $tempArray["contact_string"];
		}
		return $tempArray;
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */