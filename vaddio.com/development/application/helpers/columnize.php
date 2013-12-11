<?php

if ( ! function_exists('save_url_history')){
   	function save_url_history(){
		$CI =& get_instance();
		$CI->load->library('session');
		
		
		$oldurl = $CI->session->userdata('current');
		$newurl = $CI->uri->uri_string();
		
		if($oldurl != $newurl){
			$array = array(
				'previous' => $oldurl,
				'current' => $newurl
			);
			$CI->session->set_userdata($array); 
		}
	}
}
save_url_history();


if ( ! function_exists('urlhistory_get')){
   	function urlhistory_get($which_page = 'current'){
		$CI =& get_instance();
        $CI->load->library('session');
        return $CI->session->userdata($which_page);
	}
}
