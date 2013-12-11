<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', '1');
class Training extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		set_title("Training");
		//set_keywords("keywords go here");
		//set_metadescription($content->video_summary);
				
		$this->output->css('/css/training.css');
		$data['bodyClass'] = "training";
		$data['content'] = $this->load->view('training/training_view', '', true);	
		$this->load->view('templates/main_template', $data);
	}
	
	public function whycertify(){	
		set_title("Why Certify?");
		//set_keywords("keywords go here");
		//set_metadescription($content->video_summary);	
		
		$this->output->css('/css/training.css');
		$data['bodyClass'] = "why-certify";
		$data['content'] = $this->load->view('training/training_whycertify_view', '', true);	
		$this->load->view('templates/main_template', $data);
	}
	
	
	
	public function details($id){
		
		$this->output->css('/css/training.css');
		$data['bodyClass'] = "training-details";
		$content = array();
		$content["moreinfo"] = $this->getMoreClassLinks($id);
		
		if($id == "installation" || $id == "onsite"){			
			$data['content'] = $this->load->view('training/training_detail_onsite_view', $content, true);
			set_title("Camera Tracking Certification: Design");
			//set_keywords("keywords go here");
			set_metadescription("This workshop at Vaddio Headquarters certifies integrators, dealers and consultants to install tracking systems. ");			
		} else {
			$data['content'] = $this->load->view('training/training_detail_online_view', $content, true);
			set_title("Camera Tracking Certification: Installation");
			//set_keywords("keywords go here");
			set_metadescription("Perfect for system designers and sales staff, this online course enables you to design and purchase Vaddio Tracking Systems. ");		
		}
		
		$this->load->view('templates/main_template', $data);
	}
	
	
	
	
	
	
	public function register($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('/js/form_validation.js');
		$this->output->css('/css/training.css');
		$content = array();
		
		
		$this->form_validation->set_rules($this->getValidationRules()); 
		
		if ($this->form_validation->run() !== FALSE){ // Form was submitted and there were no errors
			
			$this->load->model('training_model');
			$sessionData = $this->training_model->getClassSessions(NULL,$this->input->post("session_id"));
			if(count($sessionData) <= 0){
				echo "Sorry, there was an error a session with an ID of '".$this->input->post("session_id")."' from the database";
				exit();
			}
			
			if(!$registration_id = $this->processRegistrationForm()){
				echo "Sorry, there was an error saving your registration request. Please feel free to <a href='/contact'>contact us</a> directly.";
				exit();
			}
			
			
			if(!$this->sendEmailToRegistrant($sessionData)){
				echo "Sorry, there was an error sending the email to the registrant at \"" . $this->input->post("email") . "\"";
				//echo $this->email->print_debugger();
				exit();
			}
			
			if(!$this->sendEmailToAdmin($sessionData)){
				echo "Sorry, there was an error sending the email to the administrator";
				//echo $this->email->print_debugger();
				exit();
			}
			
			$this->load->helper('url');
			redirect('/training/success/'.$registration_id, 'location', 301);
			exit();			
		}
		
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');			
		$this->load->model('training_model');	
		
		if($id == "onsite" || $id == "installation"){
			$class_id = 2;
			$data['bodyClass'] 	=  "training-register training-register-onsite";
			$headline 			=  "Hands-on Installation Tracking Certification at Vaddio Headquarters";
			set_title("Register for Hands-on Installation Certification");
			//set_keywords("keywords go here");	
			set_metadescription("Register for this workshop at Vaddio Headquarters for certification for integrators, dealers and consultants to install tracking systems.");
		} else {
			$class_id = 1;				
			$data['bodyClass'] 	=  "training-register training-register-online";
			$headline 			=  "AutoTrak Camera Tracking Certification - Sales - Design Online";
			set_title("Register for AutoTrak Camera Tracking Certification ");
			//set_keywords("keywords go here");
			set_metadescription("Register for this online workshop at Vaddio, perfect for system designers and sales staff. This online course will enable you to design and purchase Vaddio Tracking Systems.");
		}
		set_metadescription($headline);		

		$classes = $this->training_model->getClassInfo($class_id);
		$content = $classes[0];
		
		$content["moreinfo"] = $this->getMoreClassLinks($id);
		$content["classes"] = $this->training_model->getClassSessions($class_id);
		$content['headline'] = $headline;
		$data['content'] = $this->load->view('training/training_register_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	
	
	
	private function getMoreClassLinks($id){
		$this->load->model('doc_library_model');
		$moreinfo = array();
		if($id == "onsite" || $id == "installation"){
			$class_id = 1;
			$moreinfo["Course Details"] 			=  $this->doc_library_model->getDocLibraryPlacement('installation course details');
			$moreinfo["Your Schedule at Vaddio"] 	=  $this->doc_library_model->getDocLibraryPlacement('installation schedule');
			$moreinfo["Lodging"] 					=  $this->doc_library_model->getDocLibraryPlacement('lodging');
			array_unshift($moreinfo["Course Details"],array(
														'type'=>'anchor',
														'path'=>base_url() . 'training/details/installation#description',
														'description'=>'Course Description'
													));
			array_unshift($moreinfo["Your Schedule at Vaddio"],array(
														'type'=>'anchor',
														'path'=>base_url() . 'training/details/installation#schedule',
														'description'=>'Schedule Details'
													));														
			array_unshift($moreinfo["Lodging"],array(
														'type'=>'anchor',
														'path'=>base_url() . 'training/details/installation#lodging',
														'description'=>'Learn about Lodging Near Vaddio at Preferred Rates',
													));
			
			$data['bodyClass'] 						=  "training-register training-register-onsite";
			$headline 								=  "Hands-on Installation Tracking Certification at Vaddio Headquarters";
		} else {
			$class_id = 2;
			$moreinfo["Downloads"] 					=  $this->doc_library_model->getDocLibraryPlacement('online training downloads');
			$data['bodyClass'] 						=  "training-register training-register-online";
			$headline 								=  "AutoTrak Camera Tracking Certification - Sales - Design Online";
		}
		return $moreinfo;
	}
	
	
	
	
	
	
	public function success($registration_id){
		set_title("Training : Thank you");
		//set_keywords("keywords go here");
		//set_metadescription($content->video_summary);		

		$this->output->css('/css/training.css');
		$this->load->model('training_model');
		$content = $this->training_model->getRegistrationDetails($registration_id);
		
		$content->more_classes_link = base_url() . "training";
		
		$data['bodyClass'] = "training-success";
		$data['content'] = $this->load->view('training/training_register_success_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	
	

	private function processRegistrationForm(){
		$data = $this->input->post();
		
		unset($data["submit"]);
		unset($data["recaptcha_challenge_field"]);
		unset($data["recaptcha_response_field"]);
		$data["date_registered"] = date('Y-m-d H:i:s');
		
		//runQuery("LOCK TABLE class_sessions s READ,  classes c READ, content READ, class_registration WRITE"); // don't let any other connections read from this table until this lock is released. This eliminates two people registering at once and going over the max registration.	
		$this->load->model('training_model');
		$registration_id = $this->training_model->registerPerson($data);	
		// runQuery("UNLOCK TABLES");
		

		return $registration_id;
	}
	
	
	
	
	
	
	private function sendEmailToRegistrant($session){
		$postedData = $this->input->post();
		
		$msg = stripslashes($session["success_email"]);
		$msg = str_replace("{CLASS_ID}",				$session["session_id"],									$msg);
		$msg = str_replace("{CLASS_NAME}",				stripslashes($session["class_name"]),					$msg);
		$msg = str_replace("{CLASS_DATE}",				date("F j, Y",strtotime($session["session_start_date"])),$msg);
		$msg = str_replace("{CLASS_TIME}",				date("g:i a",strtotime($session["session_start_time"])),$msg);
		$msg = str_replace("{CLASS_CODE}",				$session["session_code"],								$msg);
		$msg = str_replace("{CLASS_DESCRIPTION}",		stripslashes($session["class_description"]),			$msg);
		$msg = str_replace("{REGISTRANT_FIRSTNAME}",	$postedData["firstname"],								$msg);
        $msg = str_replace("{REGISTRANT_LASTNAME}",		$postedData["lastname"],								$msg);
        $msg = str_replace("{REGISTRANT_COMPANY}",		$postedData["company"],									$msg);

		$subject = stripslashes($session["success_email_subject"]);
		$subject = str_replace("{CLASS_ID}",			$session["session_id"],									$subject);
		$subject = str_replace("{CLASS_NAME}",			$session["class_name"],									$subject);
		$subject = str_replace("{CLASS_DATE}",			date("F j, Y",strtotime($session["session_start_date"])),$subject);
		$subject = str_replace("{CLASS_TIME}",			date("g:i a",strtotime($session["session_start_time"])),$subject);
		$subject = str_replace("{CLASS_CODE}",			$session["session_code"],								$subject);
		$subject = str_replace("{CLASS_DESCRIPTION}",	$session["class_description"],							$subject);
		$subject = str_replace("{REGISTRANT_FIRSTNAME}",$postedData["firstname"],								$subject);
        $subject = str_replace("{REGISTRANT_LASTNAME}",	$postedData["lastname"],								$subject);
        $subject = str_replace("{REGISTRANT_COMPANY}",	$postedData["company"],									$subject);
		
		
		$this->load->library('email');
		
		// find more config values at http://ellislab.com/codeigniter/user-guide/libraries/email.html
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'text' ;	//text or html	
		$this->email->initialize($config);

		$this->email->from('"training@vaddio.com"', 'Vaddio Training');
		$this->email->to($postedData["email"]);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		
		$this->email->subject($subject);
		$this->email->message($msg);		
		if(@$this->email->send()){
			return true;
		} else {
			return false;
		}
	}
	
	
	
	private function sendEmailToAdmin($session){
		$postedData = $this->input->post();
		
		unset($postedData["submit"]);
		
		$msg = "Selected Date: " . $session["displayDate"] . "\n";	
		$msg .= "\n\nView class roster at https://www.vaddio.com/admin/registration.php?sessionid=".$postedData["session_id"];	
		
		foreach($postedData as $key=>$var){		
			if($key != 'Submit Information' && $key != 'Submit' &&  !empty($var) ){
				$key = str_replace("_"," ",$key);		
				if($key != "returnURL" && $key != "successURL" && $key != "session_id" && strtolower($key) != "submit"){	
					$msg .= "\n" . ucwords($key).":\n\t" . $var . "\n";
				}
			}		
		}
		
		
		$this->load->library('email');
		
		$this->load->model('content_model');
		$sendTo = $this->content_model->getContent("Tracking certification email recipient");	
		
		
		// find more config values at http://ellislab.com/codeigniter/user-guide/libraries/email.html
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'text' ;	//text or html	
		$this->email->initialize($config);

		$this->email->from($postedData["email"]);
		$this->email->to($sendTo);	
		$this->email->subject("Tracking Certification Enrollment");
		$this->email->message($msg);		
		if(@$this->email->send()){
			return true;
		} else {
			print"<pre>";	print $msg;
			return false;
		}
		
	}
	
	
	
	private function getValidationRules(){
		$config = array(
				   array(
						 'field'   => 'session_id',
						 'label'   => 'Class Date',
						 'rules'   => 'required' 
						 //'rules'   => 'required|user_is_not_yet_registered|is_session_available' 
					  ),
				   array(
						 'field'   => 'company',
						 'label'   => 'Company',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'dealer_nbr',
						 'label'   => 'Dealer Number',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'company_website',
						 'label'   => 'Company Website',
						 'rules'   => 'required|trim|max_length[256]|xss_clean|prep_url|valid_url_format'
						 // required|trim|max_length[256]|xss_clean|prep_url|valid_url_format|url_exists|callback_duplicate_URL_check
					  ),
				   array(
						 'field'   => 'firstname',
						 'label'   => 'First Name',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'lastname',
						 'label'   => 'Last Name',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'address',
						 'label'   => 'Address',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'city',
						 'label'   => 'City',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'state',
						 'label'   => 'State',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'zip',
						 'label'   => 'Zip',
						 'rules'   => 'max_length[10]'
					  ),
				   array(
						 'field'   => 'phone',
						 'label'   => 'Phone',
						 'rules'   => 'max_length[20]'
					  ),
				   array(
						 'field'   => 'fax',
						 'label'   => 'Fax',
						 'rules'   => 'max_length[20]'
					  ),
				   array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'required|valid_email'
					  ),
				   array(
						 'field'   => 'recaptcha_challenge_field',
						 'label'   => 'Security Question',
						 'rules'   => 'required|validate_recaptcha'
					  ),
				   array(
						 'field'   => 'recaptcha_response_field',
						 'label'   => 'Retyped Secret Code',
						 'rules'   => 'required'
					  )
				);
		return $config;
	}
	
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */