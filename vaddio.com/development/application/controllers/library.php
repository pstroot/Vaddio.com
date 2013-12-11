<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Library extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -  
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	  
	 public function __construct() {
		 global $system_path;
		 global $application_folder;
		 
        parent::__construct();   
		// Paths relative to this script (applicatin/controllers/library.php)		
		$this->defaultPath = '/../../images/';
		$this->paths = array();
		
		$this->paths["d"]   = '/../document_library/library_docs/';
		$this->paths["pm"]  = '/../document_library/promotions/';
		$this->paths["cat"] = '/../document_library/catalog/';
		$this->paths["n"]   = '/../document_library/newsroom/';
		$this->paths["pr"]  = '/../document_library/newsroom/press_releases/';
		$this->paths["e"]   = '/../document_library/newsroom/events/';
		$this->paths["wp"]  = '/../document_library/newsroom/white_papers/';
		$this->paths["p"]   = '/../document_library/newsroom/partner_docs/';
    }
	
	
	
	public function index(){
		// make sure a filename was passed in through the querystring.
		if(!$this->input->get("file")){
			die('you must pass in a filename');
		}
		
		// the variable "path" is passed in through the querystring so that we can hide the actual path to the images.
		if(!$this->input->get("path")){
			$thisDir = $this->defaultPath;
		} else {
			 // if this is a partners doc, make sure the user is logged in.
			if($this->input->get("path") == "p"){
				$this->requireLogIn();
			}
			
			
			if(@$this->paths[$this->input->get("path")]){
				$thisDir = $this->paths[$this->input->get("path")];
			} else {
				print "uh oh";
				$thisDir = $this->defaultPath;	
			}
		}
		
		$this -> checkIfDirectoryExists($thisDir);
		$wholePath = dirname(__FILE__) . $thisDir  . urldecode($this->input->get("file"));
		
		$whilePath = str_replace('\\','/',$wholePath);
		
		$this -> checkIfFileExists($wholePath);
		
		$path = $this->getRealPath($wholePath);
		$this->displayFile($path);
		
		
		
	}
	
	
	
	
	public function requireLogin(){
		if(!$this->authorization->is_logged_in()){
			echo '<h1>Protected File</h1>This is a protected file available only to our partners.If you are a Vaddio partner and would like to access this file, please <A href="'.base_url().'login">Click here</a> to log in. ';
			die("you must be logged in to view this file");	
		}
	}
	
	
	private function checkIfFileExists($file){
		if (!is_file($file)) {
			header('HTTP/1.0 404 Not Found');
			print "File does not exist";
			print "<BR><a href='".$file."'>$file</a>"; 
			exit();
		}
	}
	
	private function checkIfDirectoryExists($dir){
		if (!is_dir(dirname(__FILE__) . $dir)) {
			header('HTTP/1.0 404 Not Found');
			print "Directory does not exist";
			print "<BR>".dirname(__FILE__) . "$dir";
			exit();
		}
	}
	
	private function getRealPath($wholePath){
				
		$path = realpath($wholePath);
		
		//$parts = explode('/', pathinfo($path, PATHINFO_DIRNAME)); 
		//if ($parts[(count($parts)-2)] !== 'document_library') {
			// LFI attempt
			//print "There is a problem with the path to the file.";
			//print "<pre>";print_r($parts);
			//exit();
		//}	
		return $path;
	}
	
	private function displayFile($path){
		// Pull the filename from the full file path. First, determine if the server uses forward slashes or backslashes to dilimit files
		$filepath_dilimiter = (ENVIRONMENT == "development") ? "\\" : "/";
		// then take all of the string after the last dilimiter
		$filename = substr($path, strrpos($path, $filepath_dilimiter )+1 );
		
		// get the file extension so we can determine if this is a hex or pdf file
		$ext = strtolower(substr($filename, strrpos($filename, "." )+1 ));
		
		$content_type = mime_content_type($path);
		/* sample:
		/usr/home/vaddio/public_html/v2.vaddio.com/staging/application/document_library/library_docs/EasyTalkWirelessLavalierSystem.pdf
		*/
		
		if($ext == "msi") {
			$content_type = "application/octet-stream";
		}
		
		if($content_type == "application/pdf" || $ext == "msi" || $ext == "hex" || $ext == "pdf" || $content_type == "application/zip" || $ext == "zip" )	$content_disposition = "attachment"; // Do not open PDFs in teh browser window, instead, prompt the user to download it or open it on their computer.	
		else									$content_disposition = "inline";
		

		header('Content-Type: ' . $content_type);
		header('Content-Length: ' . filesize($path));		
		header("Content-Disposition: $content_disposition; filename=$filename"); 
		readfile($path);
  		exit; //and exit
	}
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */