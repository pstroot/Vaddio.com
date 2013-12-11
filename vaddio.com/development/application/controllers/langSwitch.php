<?php
class LangSwitch extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');	
    }

    function switchLanguage($language = "") {
		
		//print "Switching to $language";
		
		
		if(strtolower($language) == "english"){
			$goto = $this->config->item('english_base_url');
		} else {
			$goto = $this->config->item('spanish_base_url');
		}
		
		//$this->session->set_userdata('language', array('site_lang'=>$lang_name,'database_suffix'=>$db_suffix,'domain'=>$domain));
		
		
		$this->load->helper('UrlHistory');
		$prev = urlhistory_get('previous');
		$goto .= ($prev != NULL) ? $prev : '';
		
		
		//print "goto " . $goto . "<BR>";
        redirect($goto);
    }
}