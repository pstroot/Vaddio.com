<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('authorization');
	}
	
	public function index(){
		set_title("Dealers Login");
		
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		
		$this->output->css("/css/login.css");
		$this->output->css("/css/dealers.css");
		$data['bodyClass'] = "login";
		$content = array();
		if($this->authorization->is_logged_in()){
			header("Location: /my_info/editInfo");
			//$data['content'] = "<h1>Welcome</h1><p><a href='/logout'>Log Out</a></p>";
		} else {		
			$this->load->library('form_validation');			
			$this->form_validation->set_rules($this->getValidationRulesForLogin());
			$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');	
	
			if($this->form_validation->run() !== false){
				$this->load->model('users_model');
				$result = $this->users_model->verify_user(
														  $this->input->post('username'),
														  $this->input->post('password')
													   );
				if($result !== false){
					$this->authorization->log_in($result);	
				} else {
					$content['errorMessage'] = "We could not log you in with the username and password you provided.";
				}
			}
			
			$data['content'] = $this->load->view('login_view',  $content, true);
		}
		
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	
	
	
	
	public function logout(){
		$this->authorization->log_out();
	}






	public function forgotPassword(){
		set_title("Forgot Password");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		
		$this->output->css("/css/login.css");
		$this->output->css("/css/dealers.css");
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('js/form_validation.js');
		
		$data['bodyClass'] = "forgot-password";

		$this->form_validation->set_rules($this->getValidationRulesForForgotPassword()); 
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		
		if($this->form_validation->run() !== false){
			
			$this->load->model('users_model');
			$user = $this->users_model->getUserByEmail($this->input->post('email'));
			if(count($user) == 0){
				$content['success'] = false;
				$content['errorMessage'] = "We could not find your email in our database.";
			} else {
				$username = $user->user_username;
				$newPassword = $this->users_model->generateRandomPassword();
				$this->users_model->forgotPassword_resetPassword($newPassword,$this->input->post('email'));
				if($this->emailNewPasswordToUser($username,$newPassword,$this->input->post('email'))){
					$content['success'] = true;
				} else {
					$content['success'] = true;
					$content['errorMessage'] = "We've reset the password for your account, but there were problems sending you an email with the updated password. Your new password is <b>" . $newPassword . "</b>. Please log in and immediately change it to a password of your choosing";					
				}
				
			}
			
			
			$data['content'] = $this->load->view('login_forgot_password_view',  $content, true);
		} else {
			$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');	
			$content['success'] = false;
			$data['content'] = $this->load->view('login_forgot_password_view', $content, true);	
		}
			
		$this->load->view('templates/main_template', $data);	
		
	}
		
		
		
		
	private function emailNewPasswordToUser($username,$newPassword,$email){
		$this->load->library('email');
		
		$this->load->model('content_model');
		$sendTo = $this->content_model->getContent("Partner Application Email Recipient");	
		
		$msg = "We have reset your password for accessing exclusive Partner content on the Vaddio website. Use the username and password below to log in, then go to \"My Info\" at the top of the page and change your password immediately. Thank you for being a valued Partner. \n\nUSERNAME: ".$username."\nPASSWORD: " . $newPassword . "\n\nTo Log In, go to http://www.vaddio.com/login.php";
		
		// find more config values at http://ellislab.com/codeigniter/user-guide/libraries/email.html
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'text' ;	//text or html	
		$this->email->initialize($config);

		$this->email->from("registration@vaddio.com", 'Vaddio.com');
		$this->email->to($email);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		
		$this->email->subject("Vaddio Password Reset");
		$this->email->message($msg);		
		if(@$this->email->send()){
			return true;
		} else {
			return false;
		}
	}
		
		
		
		
	private function getValidationRulesForLogin(){		
		$config = array(
				   array(
						 'field'   => 'username',
						 'label'   => 'User Name',
						 'rules'   => 'trim|required|xss_clean'
					  ),
				   array(
						 'field'   => 'password',
						 'label'   => 'Password',
						 'rules'   => 'trim|required|min_length[5]|max_length[20]'
					  )
				);
		return $config;
	}
	
	private function getValidationRulesForForgotPassword(){		
		$config = array(
				   array(
						 'field'   => 'email',
						 'label'   => 'Email Address',
						 'rules'   => 'trim|required|valid_email'
					  )
				);
		return $config;
	}
		
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */