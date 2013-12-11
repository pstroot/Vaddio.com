<?php
class MY_Form_validation extends CI_Form_validation{    
     function __construct($config = array()){
        parent::__construct($config);
		$this->CI =& get_instance();
     }

	public function is_password_of_logged_in_user($password){

		$this->CI->load->model('users_model');
		$user = $this->CI->users_model->getLoggedInUser();
		$salt = $user->salt;
		$submitted_password = $this->CI->users_model->encryptPassword($password,$salt);
		
		if($submitted_password == $user->password){
			return true;
		}
		$this->CI->form_validation->set_message('is_password_of_logged_in_user', 'You entered an incorrect current password.');
		return false;
		
	}
	
	 /**
     * Validate URL format
     *
     * @access  public
     * @param   string
     * @return  string
     */
    function valid_url_format($str){
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)){
            $this->set_message('valid_url_format', 'The URL you entered is not correctly formatted.');
            return FALSE;
        } 
        return TRUE;
    }   
	
	
	
	
	// Validate the captcha submission.
	function validate_recaptcha($str){
		$this->CI->load->helper('recaptchalib');
		$resp = recaptcha_check_answer($this->CI->config->item('recaptcha_private_key'),$_SERVER["REMOTE_ADDR"],$this->CI->input->post("recaptcha_challenge_field"),$this->CI->input->post("recaptcha_response_field"));
		if(!$resp->is_valid) {
			$this->set_message('validate_recaptcha','Your answer for the security question was incorrect, please try again.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
	
	function is_session_available($session_id){		
		$this->CI->load->model('training_model');
		$sessions = $this->CI->training_model->getClassSessions(NULL,$session_id);
		$session = $sessions[0];

					
		if($session["spots_available"] <= 0){
			$this->set_message("is_session_available", "Sorry, the class you requested has just filled up.");
			return false;
		}
					
		if($session["closed"] == true){
			$this->set_message("is_session_available", "Sorry, this class you requested has just been closed.");
			return false;
		}
		if (isset($session["registration_close_date"]) && $session["days_left_to_register"] < 0){ 
			 $this->set_message("is_session_available", "Sorry, The class you requested closed on " . date("F j",strtotime($session["registration_close_date"])));
			return false;	
		}		
		return true;
	}
	
	
	function user_is_not_yet_registered($session_id){
		// Check to see if this person has already registered for a session
		$this->CI->load->model('training_model');
		$isRegistered = $this->CI->training_model->isUserRegistered($session_id,$this->CI->input->post('email'),$this->CI->input->post('lastname'),$this->CI->input->post('firstname'));		
		$this->set_message("user_is_not_yet_registered", "You have already been registered for this class.");
		return !$isRegistered;	
	}
	
	
	   
 


}