<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model{
	
	function __construct()
    {
        parent::__construct();
    }
	
	
	/*
	METHOD selectActiveLanguage
	takes a row of datafrom the database and gets the column representing the active language
	
	This requires the database is set up with a separate row for each column, with each column being named as 'colName_language' (i.e. name_sp, or description_fr).
	The defaultlanguage row should hvae no suffix for a language.

	The $data parameter must contain the data for both the default language and the active language.	
	*/
	
	/*
	public function selectActiveLanguage($data,$colName,$delete_old_values = TRUE){
		
		if(is_array($data)){
			if(isset($data[$colName.$this->db_suffix]) && trim($data[$colName.$this->db_suffix]) != ''){
				$returnThis = $data[$colName.$this->db_suffix];
			} else if(isset($data[$colName])){
				$returnThis = $data[$colName];
			} else {
				$returnThis = false;	
			}
			
			if($delete_old_values){
				unset($data[$colName]);
				unset($data[$colName.$this->db_suffix]);
			}
		} else {
			if(isset($data->{$colName.$this->db_suffix}) && trim($data->{$colName.$this->db_suffix}) != ''){
				$returnThis = $data->{$colName.$this->db_suffix};
			} else if(isset($data->{$colName})){
				$returnThis = $data->{$colName};
			} else {
				$returnThis = false;	
			}
			
			if($delete_old_values){
				unset($data->{$colName});
				unset($data->{$colName.$this->db_suffix});
			}
		}
		
		return $returnThis;
	}
	*/

	
}