<?php

class Doc_library_model extends MY_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function getDocument($id){
		
	}

	public function getProductDownloads($product_id = NULL,$order_by = "d.download_order"){
		$categories = $this->getProductDownloadCategories();
		for($ii=(count($categories)-1); $ii>=0; $ii--){
			
			if($product_id) $this->db->where('d.product_id',$product_id);
			
			$query = $this->db->select('name, description,summary,path,type,size ')
							  ->join('product_download_categories c','c.cat_id = d.cat_id','left')
							  ->join('document_library l','l.doc_id = d.doc_id ','left')
							  ->where('d.cat_id',$categories[$ii]["cat_id"])
							  ->order_by($order_by)
							  ->distinct()
							  ->get("product_downloads d");	
			$Results = $query->result_array();	
			if($query->num_rows() == 0){
				unset($categories[$ii]);
				continue;	
			}
			for($i=0; $i<=(count($Results)-1); $i++){		
				$Results[$i]["path"] 	= $this->filterDocPath($Results[$i]["path"]);
				$Results[$i]["size"] 	= $this->formatFilesize($Results[$i]["size"]);
				$Results[$i]["type"] 	= $this->displayDocumentType($Results[$i]["type"],"(",")");
			}
			$categories[$ii]["downloads"] = $Results;
			
		}
		return $categories;
	}
	
	public function getProductDownloadCategories(){
		$query = $this->db->select('c.cat_id, c.cat_name, c.cat_description, c.cat_description')
						  ->where('c.isActive',1)
						  ->order_by('c.cat_order')
						  ->distinct()
						  ->get("product_download_categories c");
						  
		$Results = $query->result_array();	
		return $Results;
	}
	
	
	public function getDocLibraryPlacement($categoryName){
		$query = $this->db->select('name,description,summary,path,type,size ')
						  ->join('document_library_placement d','l.doc_id = d.doc_id','left')
						  ->where('d.category',$categoryName)
						  ->where('l.isActive', 1)
						  ->get("document_library l");	
		$Results = $query->result_array();	
		
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["type"] 	= $this->displayDocumentType($Results[$i]["type"]);
			$Results[$i]["size"] 	= $this->formatFilesize($Results[$i]["size"]);
			$Results[$i]["path"] 	= $this->filterDocPath($Results[$i]["path"]);
			
		}
		
		return $Results;
	}
	
	
	
	public function getOtherResources($cat_id = NULL,$showFiles = false, $showSubCategories = false ){
		
		if($cat_id) $this->db->where('c.cat_id',$cat_id);
		
		$query = $this->db->select('*')
					  ->where('c.cat_parent',0)
					  ->where('c.isActive', 1)
					  ->order_by('c.cat_order')
					  ->distinct()
					  ->get("support_featured_docs_categories c");	
		$Results = $query->result_array();	
		

			
		for($i=0; $i<=(count($Results)-1); $i++){	
			if($showSubCategories){
				$Results[$i]["subcategories"] = $this->getResourceSubCategories($Results[$i]["cat_id"]);
			}
			if($showFiles){
				$Results[$i]["downloads"] = $this->getResourceLinks($Results[$i]["cat_id"]);
			}
		}
		
		
		return $Results;
		
	}
	

	
	public function getResourceSubCategories($parent_id){
		$query = $this->db->select('*')
					  ->where('c.cat_parent',$parent_id)
					  ->where('c.isActive', 1)
					  ->order_by('c.cat_order')
					  ->distinct()
					  ->get("support_featured_docs_categories c");	
		$Results = $query->result_array();
		for($i=0; $i<=(count($Results)-1); $i++){	
			$Results[$i]["subcategories"] = $this->getResourceSubCategories($Results[$i]["cat_id"]);
			$Results[$i]["docs"] = $this->getResourceLinks($Results[$i]["cat_id"]);
		}

		return $Results;
		
	}
	
	
	public function getResourceLinks($cat_id){
	
		$query = $this->db->select('l.name, l.name_sp, l.summary, l.description, l.path, l.type, l.size')
					  ->join('document_library l','d.doc_id = l.doc_id', 'left')
					  ->where('d.cat_id',$cat_id)
					  ->where('d.isActive', 1)
					  ->where('l.isActive', 1)
					  ->order_by('l.name, d.theOrder')
					  ->distinct()
					  ->get("support_featured_docs  d");	
		
		$Results = $query->result_array();
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i]["displayName"] = $Results[$i]["name"];
			$Results[$i]["displayName"] .= " " . $this->displayDocumentType($Results[$i]["type"],"(",")");
			$Results[$i]["displayName"] .= " " . $this->formatFilesize($Results[$i]["size"]);
			$Results[$i]["type"] 		= $this->displayDocumentType($Results[$i]["type"],"(",")");
			$Results[$i]["path"] 		= $this->filterDocPath($Results[$i]["path"]);
			$Results[$i]["size"] 	= $this->formatFilesize($Results[$i]["size"]);
		}
		return $Results;
		
	}
	
	public function getVaddioLoaderFiles(){
		$output = array();
		
		$query = $this->db->select('d.name, d.path, d.size, d.type')
					  ->where("d.name LIKE '%Vaddio Loader%'")
					  ->where("d.path LIKE '%.msi%'")
					  ->where('d.isActive', 1)
					  ->get("document_library  d");
					  
		$Results = $query->result_array();
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i]["type"] 		= $this->displayDocumentType($Results[$i]["type"],"(",")");
			$Results[$i]["path"] 		= $this->filterDocPath($Results[$i]["path"]);
			$Results[$i]["size"] 	= $this->formatFilesize($Results[$i]["size"]);
		}
		$output["vaddio_loader"] = $Results;
		
		
		$query = $this->db->select('d.name, d.path, d.size, d.type')
					  ->where("d.name LIKE '%Vaddio Loader%'")
					  ->where("d.name LIKE '%Instructions%'")
					  ->where('d.isActive', 1)
					  ->get("document_library  d");
					  
		$Results = $query->result_array();
		for($i=0; $i<=(count($Results)-1); $i++){
			$Results[$i]["type"] 		= $this->displayDocumentType($Results[$i]["type"],"(",")");
			$Results[$i]["path"] 		= $this->filterDocPath($Results[$i]["path"]);
			$Results[$i]["size"] 	= $this->formatFilesize($Results[$i]["size"]);
		}
		$output["vaddio_loader_instructions"] = $Results;
		
		
		return $output;
	}
	
	
	public function getFAQ_docs($product_id){		  
		$q = $this->db->select('l.path, l.name, l.type, l.size, d.link_text')
					  ->join('document_library l','l.doc_id = d.document_id','left')
					  ->where('d.product_id', $product_id)
					  ->order_by("d.theOrder DESC")	
					  ->get("faq_docs d");	
		$Results = $q->result_array();	
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]["type"] 		= $this->displayDocumentType($Results[$i]["type"]);
			$Results[$i]["size"] 		= $this->formatFilesize($Results[$i]["size"]);
			$Results[$i]["path"] 		= $this->filterDocPath($Results[$i]["path"]);
		}
		return $Results;
	}
	
	
	
	
	public function formatFilesize($filesize){
		if($filesize < 1048576){
				$filesize = (number_format($filesize/1024,0)) . "k";
		} else {
				$filesize = (number_format($filesize/1024/1024,2)) . "mb";
		}
		return $filesize;
	}
	

	
	/*
	METHOD: filterDocPath
		@attr: $file = path to the file we would like to download.	
		this take a filepath and routes it through a controller for display. This allows files to be placed off the web root, and to do user-authentication before displaying the file
		it also allows is to correct for a depreciated directory struction that is saved in teh database for each of the file names.
	*/
	public function filterDocPath($file){
		return base_url() . "library?path=d&file=" .  $file;
	}
	
	public function displayDocumentType($type, $before = '', $after = ''){
		 $mime_types = array(
	
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',
	
			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'jpg' => 'image/jpg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',
	
			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',
	
			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',
	
			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',
	
			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'xls' => 'application/vnd.ms-e',
			'ppt' => 'application/vnd.ms-powerpoint',
			
	
			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);
		
		
		// check if the value exists, if so, give the key
		foreach($mime_types as $key => $val){
			if(strtolower($val) == strtolower($type)){
				return $before . strtoupper($key) . $after;
			}
		}
		
		/*
		// this would check to see if the key exists, then give the value
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		*/
		if($type != ''){
			return $before . $type . $after;
		}
	}

	

	
	
	
}