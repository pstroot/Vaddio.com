<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_info extends MX_Controller {

	
	public function __construct() {
		$this->load->library('authorization');
		$this->authorization->require_login();		
	}

	public function index(){	
		set_title("Dealers");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
			
		$this->output->css("/css/my_info.css");
		$this->output->css("/css/dealers.css");
		$data['bodyClass'] = "my-info";
		
		$content = array();
		$this->load->model('users_model');
		$content["user"] = $this->users_model->getLoggedInUser();
		$data['content'] = $this->load->view('my_info_view', $content, true);	
		$this->load->view('templates/main_template', $data);
	}
	
	
	public function editInfo(){		
		set_title("Dealers");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('js/form_validation.js');
		$this->output->css("/css/my_info.css");
		$this->output->css("/css/dealers.css");
		$this->load->model('users_model');
		

		$content = array();
		$this->form_validation->set_rules($this->getValidationRules()); 
		if ($this->form_validation->run() == FALSE)
		{			
			$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
			$data['bodyClass'] = "my-info";
			$content["user"] = $this->users_model->getLoggedInUser();
			$content["user"]->user_id = $this->session->userdata["userdata"]->user_id;
			$data['content'] = $this->load->view('my_info_edit_view', $content, true);	
		}
		else
		{
			$userID = $this->processEditForm();
			$this->load->helper('url');
			redirect('/my_info', 'location', 301);
			exit();
		}
		
					
		$this->load->view('templates/main_template', $data);
	}

	private function processEditForm(){
		$data = $this->input->post();
		unset($data["submit"]);
		$this->load->model('users_model');		
		return $this->users_model->updateUser($data['user_id'],$data);		
	}
	
	
	
	

	public function editPassword(){		
		set_title("Change Password");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->javascript('js/form_validation.js');
		$this->output->css("/css/my_info.css");
		$this->output->css("/css/dealers.css");
		$this->load->model('users_model');
		

		$content = array();
		$this->form_validation->set_rules($this->getValidationRulesForPassword()); 
		if ($this->form_validation->run() == FALSE)
		{			
			$content["user"]["user_id"] = $this->session->userdata["userdata"]->user_id;
			$data['bodyClass'] = "my-info my-info-editpassword";
			$data['content'] = $this->load->view('my_info_editpassword_view', $content, true);	
		}
		else
		{
			$userID = $this->processPasswordForm();
			$this->load->helper('url');
			redirect('/my_info', 'location', 301);
			exit();
		}
		
					
		$this->load->view('templates/main_template', $data);
	}
	

	
	private function processPasswordForm(){
		$data = $this->input->post();
		
		unset($data["current_password"]);
		unset($data["password2"]);
		unset($data["submit"]);
						
		$this->load->model('users_model');
		$data["salt"] = $this->users_model->generatePasswordSalt();	
		$data["password"] = $this->users_model->encryptPassword($data["password"],$data["salt"]);
		
		return $this->users_model->updateUser($data['user_id'],$data);	
		
	}
	


	
	private function getValidationRules(){
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
						 'rules'   => 'trim|required|valid_email' // register_email_is_unique is in libraries/MY_Form_validation.php
					  )

				);
			return $config;
	}
	
	
	
	
	private function getValidationRulesForPassword(){
		$config = array(
				  
				   array(
						 'field'   => 'current_password',
						 'label'   => 'Current Password',
						 'rules'   => 'trim|required|is_password_of_logged_in_user'
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
					  )
				);
			return $config;
	}
		




	
}
