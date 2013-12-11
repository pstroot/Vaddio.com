<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dealers extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 
		$this->output->css("/css/dealers.css");				
	}

	public function index(){
		set_title("Dealers");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->model('dealers_model');	
		$content["categories"] = $this->dealers_model->getDocSubcategories(0);
		$data['bodyClass'] = "dealers";
		$data['content'] = $this->load->view('dealers/dealers_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	
	public function job_registration(){
		set_title("Job Registration");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		$this->output->css("/css/dealers.css");
		
		$content = array();
		$data['bodyClass'] = "job-registration";
		$data['content'] = $this->load->view('dealers/dealers_job_registration_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	
	public function job_registration_form(){
		set_title("Job Registration Form");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('js/form_validation.js');
		
		$content = array();
		
		$this->form_validation->set_rules($this->getJobRegistrationValidationRules()); 
		if ($this->form_validation->run() == FALSE)
		{			
			$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
			$data['bodyClass'] = "job-registration-form";
			$data['content'] = $this->load->view('dealers/dealers_job_registration_form_view', $content, true);	
		}
		else
		{
		
			if(!$this->processJobRegistrationForm()){
				echo $this->email->print_debugger();
				exit();
			}
			$data['bodyClass'] = "job-registration-success";
			$data['content'] = $this->load->view('dealers/dealers_job_registration_success_view.php', $content, true);
		
		
		}
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	public function docs($slug){
		
		$this->load->model('dealers_model');	
		
		$content["categories"] = $this->dealers_model->getDocCategory($slug);
		
		for($i=0; $i < count($content["categories"]); $i++){
			
			$docs = $this->_getCategoryDocs($content["categories"][$i]["category_id"]);
			if(count($docs) > 0) $content["categories"][$i]["docs"] = $docs;
			
			$subcategories = $this->_getSubCategories($content["categories"][$i]["category_id"]);
			if(count($subcategories) > 0) $content["categories"][$i]["subcategories"] = $subcategories;
			
		}
		
		$content["docs"] = $this->dealers_model->getDocs($slug);
		
		set_title("Partner Documents");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$data['bodyClass'] = "partner-docs";
		$data['content'] = $this->load->view('dealers/dealers_docs_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	private function _getSubCategories($cat_id){
		$subcategories = $this->dealers_model->getDocSubcategories($cat_id);
		for($i=0; $i < count($subcategories); $i++){
			$subcategories[$i]["docs"] = $this->_getCategoryDocs($subcategories[$i]["category_id"]);
			$subcategories[$i]["subcategories"] = $this->_getSubCategories($subcategories[$i]["category_id"]);
		}
		return $subcategories;
	}
	
	
	
	private function _getCategoryDocs($slug){
		
		$docs = $this->dealers_model->getDocs($slug);
		for($i=0; $i < count($docs); $i++){		
			$docs[$i]["display"] = $this->_getDocumentHTML($docs[$i]);			
		}
		return $docs;
	}
	
	
	private function _getDocumentHTML($doc){
		$currentCategoryID = $this->uri->segment(3);
		
		$doc_name = $doc["name"];
		$summary = $doc['summary'];
		/////////// set icon or image thumbnail //////////////////
		if ($doc['image_thumb'] != ""){
			$icon = "<img src='" . base_url() . "library?path=p&file=" . $doc["image_thumb"] . "'>";
		} else if ($doc['file_name'] != ""){
			// get the file extension and determine what thumbnail to show
			$linkTo = $doc['file_name'];
			$ext = substr($linkTo, strrpos($linkTo, '.') + 1);
			if (strtolower($ext) == "jpg" || strtolower($ext) == "jpeg" || strtolower($ext) == "gif" || strtolower($ext) == "png"){
				$icon = "<img src='" . base_url() . "library?path=p&file=" . $doc["image_thumb"] . "'>";
			} else {
				$icon = "<img src='" . base_url() . "images/partners/dealers_file_icon.png'><span>".strtoupper($ext)."</span>";
			}
			/* Deprecated
			} else if (strtolower($ext) == "pdf"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_pdf.jpg'>";
			} else if (strtolower($ext) == "ppt" || strtolower($ext) == "pptx"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_ppt.jpg'>";
			} else if (strtolower($ext) == "doc" || strtolower($ext) == "docx"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_word.jpg'>";
			} else if (strtolower($ext) == "xls" || strtolower($ext) == "xlsx"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_excel.jpg'>";
			} else if (strtolower($ext) == "dim"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_dimdim.jpg'>";
			} else if (strtolower($ext) == "php" || strtolower($ext) == "php"){
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_articleTxt.jpg'>";
			} else {
				$icon = "<img src='" . base_url() . "images/document_icons/doc_icon_blank.jpg'>";
			}
			*/
		} else {
			$icon = "";
		}

		///////////////////// determine the hyperlink /////////////////////
		if ($currentCategoryID == 2){ // if this is a promotion page
			$linkTo = "dealers/detail/" . $doc['doc_id'];
			$ext = "click for details";
		} else if ($doc['link'] != ""){
			$linkTo = $doc['link'];
			$ext = "link";
		}  else if ($doc['file_name'] != ""){
			
			$linkTo = base_url() . "library?path=p&file=" . $doc["file_name"]; //$doc['file_name'];
			//$linkTo = base_url() . $doc['filename'];
		} else if ($doc['image_fullsize'] != ""){
			$linkTo = base_url() . $doc['image_fullsize'];
			$ext = "image";
		} else {
			$linkTo = "";
			$ext = "";
		}
	
			$downloadLink = "";
		if ($doc["link_text"] != "" && $_GET["pageID"] != 2){ // don't add this if it's a promotion...the user needs to click the headline.
			$downloadLink = "<BR>  <img src='" . base_url() . "images/blueBullet2.gif'> <a href='$linkTo'>$link_text</a>";
		}
		if (isset($ext)){
			$doc_name .= " (" . strtoupper($ext) .")";
		}
		
		
		/* TAGLINE */
		$theTagline = "";
		if ($doc["tagline"] != ""){
			$theTagline = "<div id='tagline'>".$doc["tagline"]."</div>";
		}
	
	
		/* PRICE */
		$price = '';
		if ($doc["price_list"] != ""){
			$price .= "<div id='price'><b>Price:</b> $" . $doc["price_list"] . "</div>";
		}
		if ($doc["price_dealer"] != ""){
			$price .= "<div id='price'><b>Dealer Price:</b> $" . $doc["price_list"] . "</div>";
		}
		if ($price != "") $price="<div id='prices'>" .$price. "</div>";
		
		
		
		
		$d = "<div class='icon'>$icon</div>
			  <div class='detail'>
				   <a href='$linkTo' class='title'>$doc_name</a>
				   $theTagline
				   <div id='summary'>$summary $downloadLink</div>
				   $price
			   </div>";
			   
		
		return $d;
	}
	
	

	
	
	private function processJobRegistrationForm(){
		
		
		$msg = '';
		foreach($this->input->post() as $key=>$var){		
			if($key != 'submit' &&  strtolower($key) != 'token' &&  strtolower($key) != 'ref' &&  !empty($var) ){
				$key = str_replace("_"," ",$key);			
				$msg .= "\n" . ucwords($key).":\n\t" . $var . "\n";
			}		
		}

		
		$this->load->library('email');
		
		$this->load->model('content_model');
		$sendTo = $this->content_model->getContent("Job Registration Form Email Recipient");	
		
		// find more config values at http://ellislab.com/codeigniter/user-guide/libraries/email.html
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'text' ;	//text or html	
		$this->email->initialize($config);

		$this->email->from($this->input->post('dealer_email'), $this->input->post('dealer_name'));
		$this->email->to($sendTo);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		
		$this->email->subject('[website] Job Registration Submission');
		$this->email->message($msg);		
		if(@$this->email->send()){
			return true;
		} else {
			return false;
		}

	}
	
	private function getJobRegistrationValidationRules(){
		// every field should be in here in order to retain the value of the field when bouncing back from an error.
		$config = array(
				   array(
						 'field'   => 'dealer_name',
						 'label'   => 'Dealer Name',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'dealer_email',
						 'label'   => 'Dealer Email',
						 'rules'   => 'trim|required|valid_email'
					  ),
				   array(
						 'field'   => 'dealer_contact_name',
						 'label'   => 'Dealer Contact Name',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'vaddio_account_nbr',
						 'label'   => 'Dealer Contact Name',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'phone',
						 'label'   => 'Phone',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'fax',
						 'label'   => 'Fax',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'dealer_location',
						 'label'   => 'Dealer Location',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'date_of_registration',
						 'label'   => 'Date of Registration',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_company_name',
						 'label'   => 'End User Company Name',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_address',
						 'label'   => 'End User Address',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_city_state_zip',
						 'label'   => 'End User City, State and Zip',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_contact_name',
						 'label'   => 'End User Contact Name',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_contact_phone',
						 'label'   => 'End User Contact Phone Number',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_title_position',
						 'label'   => 'End User Title/Position',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'end_user_email',
						 'label'   => 'Dealer Email',
						 'rules'   => 'trim|valid_email'
					  ),
				   array(
						 'field'   => 'model_number_and_quantity',
						 'label'   => 'Model Number and Quantity',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'estimated_purchase_date',
						 'label'   => 'Estimated Purchase Date',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'estimated_delivery_date',
						 'label'   => 'Estimated Delivery Date',
						 'rules'   => ''
					  ),
				   array(
						 'field'   => 'comments',
						 'label'   => 'Comments',
						 'rules'   => ''
					  ),
				);
			return $config;
	}
		
	
	
	
	
}

/* End of file dealers.php */
/* Location: ./application/controllers/dealers.php */