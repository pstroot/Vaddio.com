<?php

if ( ! function_exists('showProductNumbers')){
   	function showProductNumbers($nbr,$label,$addtl_nbrs,$multiline = true){
		$results = "";
		if (isset($nbr) && $nbr != ""){
			$results .= trim($nbr);
		}
		if (isset($label) && $label != ""){
			$results .= " (" . trim($label) . ")";
		}
		$results = "<span class='product-nbr'>" . $results . "</span>";
		if (isset($addtl_nbrs)){
			$nbrArray = explode(";",$addtl_nbrs);
			foreach ($nbrArray as $value){
				if (trim($value) != ""){
					$splitNbrs = explode(":",$value);				
					if ($multiline) $results .= "<BR>";
					else  $results .= ", ";
					
					$thisNbr = "";
					if (isset($splitNbrs[0]) && $splitNbrs[0] != "") $thisNbr .= trim($splitNbrs[0]);
					if (isset($splitNbrs[1]) && $splitNbrs[1] != "") $thisNbr .= " (" . trim($splitNbrs[1]) . ")";
					$results .= "<span class='product-nbr'>" . $thisNbr . "</span>";
				
				}
	
			}
		}
		return $results;
	}
}



function set_title($title,$ignoreDefaults = false) {
	global $_vaddio_page_title_suffix;
	
	$site_title = "Vaddio";
	if(ENVIRONMENT == 'development') $site_title = "Vaddio Local";
	if(ENVIRONMENT == 'staging') $site_title = "VaddioDev";
		
	$CI =& get_instance();
	if ($ignoreDefaults) $CI->header_title = $title;
	else 				 $CI->header_title = $title . " &mdash; " . $site_title;	
	
}
function get_title() {
	global $_vaddio_page_title_suffix;
	
	$site_title = "Vaddio";
	if(ENVIRONMENT == 'development') $site_title = "Vaddio Local";
	if(ENVIRONMENT == 'staging') $site_title = "VaddioDev";
	
	$CI =& get_instance();
	if(isset($CI->header_title)) return stripslashes($CI->header_title);
	else 						 return ucfirst ($CI->router->fetch_class()) . " &mdash; " . $site_title;	 //default format takes the name of the controller	
}

function set_keywords($content) {
	$CI =& get_instance();
	$CI->header_keywords = $content;	
}
function get_keywords() {
	$CI =& get_instance();
	if(isset($CI->header_keywords)) return $CI->header_keywords;
	else 						 	return "vaddio, audio, video, cameras, easyusb,";
}

function set_metadescription($content) {
	$CI =& get_instance();
	$CI->header_metadescription = $content;	
}
function get_metadescription() {
	$CI =& get_instance();
	if(isset($CI->header_metadescription))  return $CI->header_metadescription;
	else 						 			return "Vaddio brings sophisticated PTZ camera technology within everyone's reach.";
}