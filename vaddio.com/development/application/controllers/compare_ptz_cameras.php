<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compare_Ptz_Cameras extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 				
	}

	public function index($showInPopup = NULL){
		set_title("Compare PTZ Cameras");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		
		$this->output->css("/css/compare_ptz_cameras.css");
		$this->output->javascript("/js/compare_ptz_cameras.js");
		
		$this->load->model('compare_ptz_cameras_model');
		$this->load->model('doc_library_model');	
		$content["rows"] = $this->compare_ptz_cameras_model->getRows();
		$content["productArray"] = $this->compare_ptz_cameras_model->getAll();
		
		$downloadLinks = $this->doc_library_model->getDocLibraryPlacement('ptz_comparison');
		$content["downloadLink"] = $downloadLinks[0];
		
		$data['content'] = $this->load->view('compare_ptz_cameras_view', $content, true);
		if($showInPopup){	
			$data['bodyClass'] = "compare-ptz";
			$this->load->view('templates/popup_template', $data);
		} else {		
			$data['bodyClass'] = "compare-ptz no-popup";
			$this->load->view('templates/main_template', $data);	
		}
	}
	public function popup(){
		$this->index(true);
	}
}
