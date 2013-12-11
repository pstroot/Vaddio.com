<?
	$attributes = array('class' => 'searchForm', 'method' => 'GET');
	
	$hidden = array('search_page' => base_url() . 'search/');
	
	echo form_open('search',$attributes,$hidden); 
	echo form_input('search', $searchString, 'placeholder="Search Vaddio.com"');
	
	if($showSubmitButton){
		echo form_submit('submit','Search');
	}
	
	echo form_close(); 
	
?>