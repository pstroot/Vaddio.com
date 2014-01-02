<?php
class Search_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	public function searchFor($input){	
	
		$searchfor = $input;
		$Results = array();		
		
		// product search
		$q = $this->db->select('p.product_name, p.product_id, p.product_summary, p.slug, p.product_thumb, p.isDiscontinued')
					  ->join('product_features f','p.product_id = f.product_id','left')
					  ->join('product_specs s','p.product_id = s.product_id','left')
					  ->where('p.isActive', 1)
					  ->where("(  p.product_description LIKE '%$searchfor%' 
								 OR  p.product_name LIKE '%$searchfor%' 
								 OR  p.product_summary LIKE '%$searchfor%' 
								 OR  p.product_demo_name LIKE '%$searchfor%'
								 OR  f.feature_description LIKE '%$searchfor%' 
								 OR  s.spec_description LIKE '%$searchfor%'
								 OR  p.product_nbr LIKE '%$searchfor%' 
								 OR  p.product_addtl_nbrs LIKE '%$searchfor%' )")
					  ->order_by("p.product_name")
					  ->distinct()
					  ->get("products p");
					 
		$Results["products"] = $q->result_array();	



		// categories search
		$q = $this->db->select('c.cat_name, c.cat_description, c.slug')
					  ->where("( c.cat_description LIKE '%$searchfor%' 
								 OR  c.cat_name LIKE '%$searchfor%' 
								  )")
					  ->order_by("c.cat_name")
					  ->distinct()
					  ->get("product_categories c");
		$Results["categories"] = $q->result_array();	
		
		
	  
		// videos search
	  	$q = $this->db->select('v.video_name, v.video_description, v.slug')
					  ->where("( v.video_name LIKE '%$searchfor%' 
								 OR  v.video_summary LIKE '%$searchfor%'
								 OR  v.video_description LIKE '%$searchfor%' 
								  )")
					  ->where('v.isActive', 1)
					  ->order_by("v.video_name")
					  ->distinct()
					  ->get("product_videos v");
		$Results["videos"] = $q->result_array();	  
					  
	   

		return $Results;
	}
	
	
	
	/* used in support section */
	public function tokeninput_productSearch($searchTerms,$and_or = 'OR'){
		$whereClauseArray = array();
		// the showProductNumbers function is in helpers/global_helper.php
		
		if(is_array($searchTerms)){
			foreach($searchTerms as $searchThis){	
				array_push($whereClauseArray,"(p.product_name LIKE '%".  $searchThis . "%' OR  p.product_nbr LIKE  '%".  $searchThis."%')");
			}
			$whereClause = implode(" " . $and_or . " ",$whereClauseArray);
		} else {
			array_push($whereClauseArray,"(p.product_name LIKE '%".  $searchTerms . "%' OR  p.product_nbr LIKE  '%".  $searchTerms."%')");
		}
		
		$whereClause = implode(" " . $and_or . " ",$whereClauseArray);
		
		$query = $this->db->select('p.product_name, p.slug, p.product_nbr, p.product_nbr_label, p.product_addtl_nbrs')
						  ->where('p.isActive', 1)
						  ->where('p.isDiscontinued', 0)
						  ->where($whereClause)						  
						  ->order_by('p.product_name')	
						  ->get("products p");
						  
		$Results = $query->result_array();	
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]['product_number_full'] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"],false);
		}
		
		return $Results;
	}
	
	
	
	
	public function search_google($searchString) {
		
		$this->load->helper('curl_class');
		
		$google_request_total = 40;
		if ($google_request_total > 20) {
			$google_request_num = 20;
			$google_request_pages = $google_request_total / 20;
		} else {
			$google_request_num = $google_request_total;
			$google_request_pages = 1;
		}
		
		// Settings
		$results = array(
			"product" => array(),
			"category" => array(),
			"videos" => array(),
			"press" => array(),
			"case-studies" => array()
		);
          $prefix_list = array(
               "product",
               "category",
               "videos",
               "press"
          );
          
          $result_count = 0;
		for ($i = 0; $i < $google_request_pages; $i++) {
			
			// Setup Request URL
			$google_request_url = "http://www.google.com/search?";
			$google_request_url .= "start=".($i*20);
			if ( ($i+1) < ceil($google_request_pages) ) {
				$google_request_url .= "&num=20";
			} else {
				if ( ($i+1) == $google_request_pages ) {
					$google_request_url .= "&num=20";
				} else {
					$google_request_url .= "&num=".(($google_request_pages-$i)*20);
				}
			}
			$google_request_url .= "&as_q=".$searchString;
			$google_request_url .= "&client=google-csbe";
			$google_request_url .= "&output=xml_no_dtd";
			$google_request_url .= "&cx=009747017498854254045:zbgfifopk-c";
			
			// Get request via cURL
	          $curl = new curl();
	          $curl->setURL($google_request_url);
	          $curl->execute();
	          
	          // Process as XML
          	$results_xml = simplexml_load_string(trim($curl->body));
          	
          	// Resize request length based upon first results
          	if ((int)$results_xml->RES->M < $google_request_total) {
          		$google_request_total = (int)$results_xml->RES->M;
          		if ($google_request_total > 20) {
					$google_request_num = 20;
					$google_request_pages = $google_request_total / 20;
				} else {
					$google_request_num = $google_request_total;
					$google_request_pages = 1;
				}
          	}
	          
	          // Organize results & categorize
	          if (isset($results_xml->RES->R)) {
	               foreach ($results_xml->RES->R as $row) {
	                    
	                    // Ignore check
	                    $ignore = false;
	                    
	                    // Trim/clean-up URL
	                    $url = $url = (string)$row->U;
	                    $url = str_replace("http://www.vaddio.com","",$url);
	                    $url = str_replace("http://vaddio.com","",$url);
	                    $url = str_replace("https://www.vaddio.com","",$url);
	                    $url = str_replace("https://vaddio.com","",$url);
	                    $url = strtolower($url);
	                    
	                    // Remove results from "old" site
	                    $prefix_check = false;
	                    foreach ($prefix_list as $prefix) {
	                         if (substr($url,0,strlen($prefix)+1) == "/".$prefix) {
	                              $prefix_check = true;
	                              $category = $prefix;
	                         }
	                    }
	                    if (!$prefix_check) {
	                         $ignore = true;
	                    }
	                    
	                    // Add to array if ok
	                    if (!$ignore) {
	                         
	                         // Set slug values
                              $slug = str_replace("/".$category."/","",$url);
                              $slug_parts = explode("/",$slug);
                              $slug = $slug_parts[count($slug_parts)-1];
                              
                              // Setup results by category
                              if ($category == "product") {
                              	$query = $this->db->select('p.product_name, p.slug, p.product_thumb, p.product_nbr, p.product_nbr_label, p.product_addtl_nbrs, isDiscontinued')
									  ->where('p.isActive', 1)
									  ->where('p.slug', $slug)
									  ->join('product_features f','p.product_id = f.product_id','left')
						  			  ->join('product_specs s','p.product_id = s.product_id','left')
									  ->get("products p");
							$Results = $query->result_array();	
							for($n=0; $n<=(count($Results)-1); $n++){		
								$Results[$n]['product_number_full'] = showProductNumbers($Results[$n]["product_nbr"],$Results[$n]["product_nbr_label"],$Results[$n]["product_addtl_nbrs"]);
							}
						} else if ($category == "category") {
							$query = $this->db->select('*')
									  ->where("slug",$slug)
									  ->get("product_categories");
							$Results = $query->result_array();
						} else if ($category == "videos") {
							$query = $this->db->select('*')
									  ->where('isActive', 1)
									  ->where("slug",$slug)
									  ->get("product_videos");
							$Results = $query->result_array();
						} else if ($category == "press") {
							$query = $this->db->select('*')
									  ->where('isActive', 1)
									  ->where("slug",$slug)
									  ->get("press_releases");
							$Results = $query->result_array();
							$Results[0]["description"] = (string)$row->S;
							$query = $this->db->select("case_study_id")
									  ->where("press_release_id",$Results[0]["id"])
									  ->get("case_studies");
							$case_studies_check = $query->result_array();
							if (count($case_studies_check) > 0) {
								$category = "case-studies";
							}
						}
						if (count($Results) > 0) $results[$category][] = $Results[0];
	                         
	                    }
	               }
	          }
			
		}
		
		return $results;
		
	}
	
	
	
	
	public function search_products($searchString,$and_or = "OR", $detailed_search = false){
		$searchArr = $this->searchstring_to_array($searchString);
		
		//print "<pre>";print_r($searchArr);print "</pre>";
		
		$whereArray = array();
		foreach($searchArr as $match){
			if(!$detailed_search){
				array_push($whereArray,"(
					   p.product_name 			LIKE '%" . addslashes($match) . "%'
					OR p.product_nbr 			LIKE '%" . addslashes($match) . "%' 
					OR p.product_addtl_nbrs 	LIKE '%" . addslashes($match) . "%'
				)");	
			} else {
				array_push($whereArray,"(
					   p.product_name 			LIKE '%" . addslashes($match) . "%' 
					OR p.product_nbr 			LIKE '%" . addslashes($match) . "%'
					OR p.product_addtl_nbrs 	LIKE '%" . addslashes($match) . "%' 
					OR p.product_description 	LIKE '%" . addslashes($match) . "%' 
					OR p.product_summary 		LIKE '%" . addslashes($match) . "%' 
					OR p.product_demo_name 		LIKE '%" . addslashes($match) . "%' 
					OR f.feature_description 	LIKE '%" . addslashes($match) . "%' 
					OR s.spec_description 		LIKE '%" . addslashes($match) . "%'
				)");
			}
			
			
		}

		
		
		if(count($whereArray) > 0){ 
		 	$this->db->where("(" . implode(" $and_or ",$whereArray) . ")");
		}
				

								 
								 				  
		$query = $this->db->select('p.product_name, p.slug, p.product_thumb, p.product_nbr, p.product_nbr_label, p.product_addtl_nbrs, isDiscontinued ')
						  ->where('p.isActive', 1)
						  ->join('product_features f','p.product_id = f.product_id','left')
						  ->join('product_specs s','p.product_id = s.product_id','left')
						  ->distinct()
						  ->order_by('p.product_order, p.product_name')	
						  ->get("products p");
		
		$Results = $query->result_array();	
		for($i=0; $i<=(count($Results)-1); $i++){		
			$Results[$i]['product_number_full'] = showProductNumbers($Results[$i]["product_nbr"],$Results[$i]["product_nbr_label"],$Results[$i]["product_addtl_nbrs"]);
		}
		
		return $Results;

	}
	
	
	
	
	public function search_downloads($searchString,$and_or = "OR"){
		$searchArr = $this->searchstring_to_array($searchString);
		
		//print "<pre>";print_r($searchArr);print "</pre>";
		
		$whereArray = array();
		foreach($searchArr as $match){			
			array_push($whereArray,"(
							d.name 			LIKE '%" . addslashes($match) . "%' " .
				$and_or . " d.description 	LIKE '%" . addslashes($match) . "%' " . 
				$and_or . " d.summary 		LIKE '%" . addslashes($match) . "%' " . 
				$and_or . " d.keywords 		LIKE '%" . addslashes($match) . "%'
			)");
		}
		if(count($whereArray) > 0){ 
		 	$this->db->where("(" . implode(" AND ",$whereArray) . ")");
		}
								  
		$query = $this->db->select('*')
						  ->where('d.isActive', 1)
						  ->order_by('d.name')	
						  ->get("document_library  d");
		
		$Results = $query->result_array();	
		return $Results;
	}
	
	
	
	
	public function search_categories($searchString,$and_or = "OR"){
		$searchArr = $this->searchstring_to_array($searchString);
		
		//print "<pre>";print_r($searchArr);print "</pre>";
		$whereArray = array();
		foreach($searchArr as $match){			
			array_push($whereArray,"(
				cat_description 		LIKE '%" . addslashes($match) . "%' " .
				$and_or . " cat_name 	LIKE '%" . addslashes($match) . "%'
			)");
		}
		if(count($whereArray) > 0){ 
		 	$this->db->where("(" . implode(" AND ",$whereArray) . ")");
		}
								  
		$query = $this->db->select('*')
						  ->order_by('cat_name')	
						  ->get("product_categories");
		
		$Results = $query->result_array();	
		return $Results;
	}
	
	
	
	public function search_videos($searchString,$and_or = "OR"){
		$searchArr = $this->searchstring_to_array($searchString);
		
		//print "<pre>";print_r($searchArr);print "</pre>";
		$whereArray = array();
		foreach($searchArr as $match){			
			array_push($whereArray,"(
							video_description 	LIKE '%" . addslashes($match) . "%' " .
				$and_or . " video_name 		  	LIKE '%" . addslashes($match) . "%' " .
				$and_or . " video_summary 		LIKE '%" . addslashes($match) . "%'
			)");
		}
		if(count($whereArray) > 0){ 
		 	$this->db->where("(" . implode(" AND ",$whereArray) . ")");
		}
								  
		$query = $this->db->select('*')
						  ->where('isActive', 1)
						  ->order_by('video_name')	
						  ->get("product_videos");
		
		$Results = $query->result_array();	
		return $Results;
	}
	
	
	
	
	
	
	
	
	
	
	public function searchstring_to_array($str){
		
		$text = str_replace("\'","&apos;",$str);
		$text = str_replace("%20"," ",$text);
		preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $text, $matches);
		for($i=0; $i < count($matches[0]); $i++){ 
			$matches[0][$i] = urldecode($matches[0][$i]); 
			$matches[0][$i] = str_replace('"','',$matches[0][$i]); 
			$matches[0][$i] = str_replace("\'","&apos;",$matches[0][$i]); 
			//$matches[0][$i] = $mysqli->real_escape_string($matches[0][$i]);
		} // remove double quotes
		$searchTermArray = ($matches[0]);
		return $searchTermArray;
	}

	
}