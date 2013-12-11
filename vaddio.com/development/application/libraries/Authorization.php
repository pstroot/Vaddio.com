<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorization {

	
    public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->helper('UrlHistory');	
		$this->CI->load->helper('url');	
    }
	
	public function log_in($data){
		unset($data->password);
		unset($data->salt);
		
		$this->CI->session->unset_userdata('userdata');
		$this->CI->session->set_userdata(array(
											'userdata'=>$data
										   )
									 );
		$goto = $this->CI->session->userdata('login_redirect') ? $this->CI->session->userdata('login_redirect') : base_url() . "dealers";

		//redirect($base_url . $goto); 
		redirect($goto); 
	}
	
	public function log_out(){
		$this->CI->session->unset_userdata('userdata');
		redirect('login');
	}
	
	public function is_logged_in(){
		if($this->CI->session->userdata('userdata')){
			return true;
		}		
		return false;		
	}
	
	public function show_prices(){
		if($this->is_logged_in()){
			$userdata = $this->CI->session->userdata('userdata');
			if($userdata->show_prices == 1) return true;
		}		
		return false;		
	}
	
	public function require_login(){
		$thispage = urlhistory_get('current');
		$this->CI->session->set_userdata('login_redirect' , $thispage);
		
		if(!$this->is_logged_in()){ 
			redirect('login');	
		}		
	}
	
	
	public function get_permission_level(){
		// NOTE: Not yet implemented. See user_model->verify_user for more on how this might be implemented
		//$level = $this->CI->session->userdata('userdata')->'permissions';	
		//return $level;		
	}
	
}

/* End of file Authorization.php */