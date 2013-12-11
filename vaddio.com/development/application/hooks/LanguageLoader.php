<?php
class LanguageLoader
{
    function initialize() {
		
		$domain = $_SERVER['HTTP_HOST'];
		
		$ci =& get_instance();
		if (strpos($domain,'latino.') !== false) {
			$lang_name = 'spanish';
			$db_suffix = '_sp';
			$domain = $ci->config->item('spanish_base_url');
		} else {
			$lang_name = 'english';
			$db_suffix = '';
			$domain = $ci->config->item('english_base_url');
		}
		
		$ci->session->set_userdata('language', array('name'=>$lang_name,'database_suffix'=>$db_suffix,'domain'=>$domain));
		

        // $ci->load->helper('language');  /* Auto Loaded in config/autoload.php */
		$ci->lang->load('global');
		$ci->lang->load('nav');	
		$ci->lang->load($ci->router->class);	
    }
	
}