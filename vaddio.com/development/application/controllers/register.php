<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		set_title("Dealers Application");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('js/form_validation.js');
		$this->output->css("/css/dealers.css");
		
		$content = array();
		
		
		$this->form_validation->set_rules($this->getValidationRules()); 
		if ($this->form_validation->run() == FALSE)
		{			
			$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
			$data['bodyClass'] = "register";
			$data['content'] = $this->load->view('register_view', $content, true);
		}
		else
		{
			$userID = $this->processForm();
			if(!$this->sendEmailToAdmin($this->input->post())){
				echo $this->email->print_debugger();
				exit();
			}
			$data['bodyClass'] = "register-success";
			$data['content'] = $this->load->view('register_success_view', $content, true);
			
		}
		
					
		$this->load->view('templates/main_template', $data);	
	}
	

	private function processForm(){
		$data = $this->input->post();
		
		unset($data["password2"]);
		unset($data["email2"]);
		unset($data["submit"]);
		unset($data["recaptcha_challenge_field"]);
		unset($data["recaptcha_response_field"]);
		
		if(!isset($data["user_role"])) $data["user_role"] = 'NULL';
		$data["show_prices"] = (strtolower($data["user_role"]) != 'dealer') ? "0" : "1";
		$data["registration_request_date"] = date("Y-m-d h:i:s",strtotime("now"));
		$data["isValidated"] = 0;
					
		$this->load->model('users_model');
		$data["salt"] = $this->users_model->generatePasswordSalt();	
		$data["password"] = $this->users_model->encryptPassword($data["password"],$data["salt"]);
		
		return $this->users_model->createUser($data);	
		
	}
	
	
	
	
	private function sendEmailToAdmin($data){
		$this->load->library('email');
		
		$this->load->model('content_model');
		$sendTo = $this->content_model->getContent("Partner Application Email Recipient");	
		
		$msg = "There has been a new partner request made through the website.		
		NAME: " . $data["user_name"] . "
		EMAIL: " . $data["user_email"] . "
		COMPANY: " . $data["user_company"] . "
		ROLE: " . $data["user_role"] . "	
		to accept this user, go to https://www.vaddio.com/admin/users_pending.php";
		
		// find more config values at http://ellislab.com/codeigniter/user-guide/libraries/email.html
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'text' ;	//text or html	
		$this->email->initialize($config);

		$this->email->from('no_reply@vaddio.com', 'Vaddio Website Auto Email');
		$this->email->to($sendTo);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		
		$this->email->subject('[website] Partner Application Submission');
		$this->email->message($msg);		
		if($this->email->send()){
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
	
	private function getValidationRules(){
		$this->form_validation->set_message('is_unique', 'There is already a user with this email. <a href="/login/forgotPassword">Click here</a> if you\'ve forgotten your password.');
		
		$config = array(
				   array(
						 'field'   => 'user_name',
						 'label'   => 'Name',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'user_company',
						 'label'   => 'Company',
						 'rules'   => 'max_length[100]'
					  ),
				   array(
						 'field'   => 'user_address',
						 'label'   => 'Address',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'user_role',
						 'label'   => 'Role',
						 'rules'   => 'trim'
					  ),
				   array(
						 'field'   => 'user_city',
						 'label'   => 'City',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'user_state',
						 'label'   => 'State',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'user_zip',
						 'label'   => 'Zip',
						 'rules'   => 'required'
					  ),
				   array(
						 'field'   => 'user_country',
						 'label'   => 'Country',
						 'rules'   => 'max_length[100]'
					  ),
				   array(
						 'field'   => 'user_phone',
						 'label'   => 'Phone',
						 'rules'   => 'max_length[100]'
					  ),
				   array(
						 'field'   => 'user_fax',
						 'label'   => 'Fax',
						 'rules'   => 'max_length[100]'
					  ),
				   array(
						 'field'   => 'user_email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email|is_unique[users.user_email]' // register_email_is_unique is in libraries/MY_Form_validation.php
					  ),
				   array(
						 'field'   => 'email2',
						 'label'   => 'Retyped Email',
						 'rules'   => 'trim|required|matches[user_email]'
					  ),
				   array(
						 'field'   => 'user_username',
						 'label'   => 'User Name',
						 'rules'   => 'trim|required|is_unique[users.user_username]|xss_clean'
					  ),
				   array(
						 'field'   => 'password',
						 'label'   => 'Password',
						 'rules'   => 'trim|required|min_length[5]|max_length[20]|matches[password2]'
					  ),
				   array(
						 'field'   => 'password2',
						 'label'   => 'Retyped Password',
						 'rules'   => 'trim|required'
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