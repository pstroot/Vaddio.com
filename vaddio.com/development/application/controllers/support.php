<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 		
		$this->output->css('/js/tokeninput/styles/token-input.css');
		$this->output->css('/css/support.css?v=031214');			
	}

	public function index(){
		set_title("Vaddio Support Center");
		//set_keywords("keywords go here");
		//set_metadescription($content["summary"]);
		
		$data['bodyClass'] = "support";
		$this->output->javascript('/js/support_home.js');	
		$this->output->javascript('/js/tokeninput/src/jquery.tokeninput.js');
		
		$this->load->model('category_model');
		$this->load->model('doc_library_model');
		$content["categories"] = $this->category_model->getCategories();
		$content["resources"] = $this->doc_library_model->getProductDownloadCategories();
		$content["resources_other"] = $this->doc_library_model->getOtherResources();
		$content["featured"] = $this->doc_library_model->getOtherResources(15,true,false);


		$data['content'] = $this->load->view('support/support_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}

	public function categoryDetail($slug){
		$this->load->model('category_model');
		$this->load->model('product_model');
		$content["categoryDetails"] = $this->category_model->getCategoryDetail($slug);
		$content["categoryProducts"] = $this->product_model->getProducts($content["categoryDetails"]->id);
		$content["subcategories"] = $this->category_model->getChildCategories($content["categoryDetails"]->id);
		
		for($i=0; $i<count($content["subcategories"]); $i++){
			$content["subcategories"][$i]["products"] = $this->product_model->getProducts($content["subcategories"][$i]["id"]);
		}
		
		$content["slug"] = $slug;		
		$this->load->view('support/support_category_detail_view', $content);	
	}
	
	public function productSupport($slug){
		$data['bodyClass'] = "support-detail";
		$this->load->model('product_model');
		$this->load->model('support_faq_model');
		$this->load->model('doc_library_model');
			
		$slug = str_replace("%20"," ",$slug);
		$content["slug"] = $slug;
		$content["productDetail"] = $this->product_model->getProductDetail($slug);
		
		if($content["productDetail"] == ''){
			 log_message('error', 'CUSTOM: Could not find support for product with slug = "'.$slug.'" at '.current_url());
			$content["slug_not_found"] = true;
		} else {			
			$content["productDetail"]['product_number_full'] = showProductNumbers($content["productDetail"]["product_nbr"],$content["productDetail"]["product_nbr_label"],$content["productDetail"]["product_addtl_nbrs"],false);
			
			$content["downloads"] = $this->doc_library_model->getProductDownloads($content["productDetail"]["id"]);
			$content["faq"] = $this->support_faq_model->getFAQ($content["productDetail"]["id"]);
			$content["faq_docs"] = $this->doc_library_model->getFAQ_docs($content["productDetail"]["id"]);
			
			set_title("Support for " . $content["productDetail"]["name"]);
			//set_keywords("keywords go here");
			set_metadescription($content["productDetail"]["summary"]);
		}
		$data['content'] = $this->load->view('support/support_product_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	

	public function resources(){
		set_title("Support Center Resource Library");
		$this->output->javascript('/js/support_product_dropdown.js');
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->output->javascript('/js/support_resources.js');
		$data['bodyClass'] = "support-resources";
		$this->load->model('doc_library_model');
		$content = array();
		$content["resources"] = $this->doc_library_model->getProductDownloads(NULL,'l.name');
		$content["resources_other"] = $this->doc_library_model->getOtherResources('',true);
		
		//print "<pre>";print_r($content["resources_other"]);
		
		$data['content'] = $this->load->view('support/support_resources_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}

	public function products(){
		set_title("Product Support");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$data['bodyClass'] = "support-products";
		$content = array();
		
		$this->load->model('category_model');	
		$this->load->model('product_model');
		$content['category_list'] = $this->category_model->getCategories();
		for($i=0; $i<count($content['category_list']); $i++){
			$content['category_list'][$i]["products"] = array_merge(
																	$this->product_model->getProducts($content['category_list'][$i]["id"]),
																	$this->getProductsForSubCategories($content['category_list'][$i]["id"])
																	);
		}
		
		$data['content'] = $this->load->view('support/support_products_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}


	public function search($search_for){
		$this->output->javascript('/js/search.js');
		$this->output->javascript('/js/jquery/jquery.highlight.js');
		$this->output->javascript('/js/support_product_dropdown.js');	
		
		set_title("Support Center Search for \"" . $search_for . "\"");
		//set_keywords("keywords go here");
		//set_metadescription($content["productDetail"]["summary"]);
		
		$this->load->model('search_model');
		$content['searchTermArray'] = $this->search_model->searchstring_to_array($search_for);
		$content['products']  =  $this->search_model->search_products($search_for);
		$content['documents'] =  $this->search_model->search_downloads($search_for);
		$content['categories'] = $this->search_model->search_categories($search_for);
		$content['videos'] = 	 $this->search_model->search_videos($search_for);
		
		for($i=0; $i<count($content['categories']); $i++){
			$content['categories'][$i]["cat_description"] = $this->truncateText($content['categories'][$i]["cat_description"]);
		}
		for($i=0; $i<count($content['videos']); $i++){
			$content['videos'][$i]["video_summary"] = $this->truncateText($content['videos'][$i]["video_summary"]);
		}
		
		//print "<pre>";print_r($products);print "</pre>";
		
		$data['bodyClass'] = "support-search";
		$content["searchFor"] = urldecode($search_for);
		$content["search_description"] = '"' . implode('" and "',$content['searchTermArray']) . '"';
		$data['content'] = $this->load->view('support/support_search_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}

	
	private function truncateText($str,$nbrCharacters = 150){
		$str = strip_tags($str);		
		if(strlen($str) <= $nbrCharacters) return $str;		
		$str = substr($str,0,$nbrCharacters);		
		$lastSpace = strrpos($str," ");				
		$str = substr($str,0,$lastSpace);		
		$str .= " ...";
		return $str;
	}
	
	
	// used on the products page so that all products will be listed under a category, even if they are a level deep (TO DO: make recursive if there are multiple levels of categories)
	private function getProductsForSubCategories($cat_id){
		$allProducts = array();	
		
		$this->load->model('product_model');
		$this->load->model('category_model');
		
		$children = $this->category_model->getChildCategories($cat_id);
		for($i=0; $i<count($children); $i++){			
			$allProducts = array_merge($allProducts,$this->product_model->getProducts($children[$i]["id"]));
		}
		return $allProducts;
	}
	
	
	
	public function tokeninput_product_search(){
		$pageArr = array();
		
		$searchThis = $this->input->get("q");
		
		preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', stripslashes($searchThis), $matches);
		for($i=0; $i < count($matches[0]); $i++){ 
			$matches[0][$i] = str_replace('"','&quot;',$matches[0][$i]);
			$matches[0][$i] = stripslashes($matches[0][$i]); 
		} // remove double quotes
		$searchTermArray = ($matches[0]);
		$searchText = "Search For \"" . implode("\" and \"",$searchTermArray) . "\"";
		
		
		$this->load->model('search_model');
		$this->load->model('product_model');
		//$results = $this->search_model->tokeninput_productSearch($searchTermArray,'OR');
		$Results = $this->search_model->tokeninput_productSearch($searchThis,'OR');
		
		array_push($pageArr,array("name"=>$searchText,"nameOnly"=>$searchThis,"slug"=>""));
		foreach($Results as $r){	
			$display_name = $r["product_name"] . $r["product_number_full"];
			array_push($pageArr,array("name"=>$display_name,"nameOnly"=>$r["product_name"],"slug"=>$r["slug"]));
		}
		
		print json_encode($pageArr);
	}
}

/* End of file support.php */
/* Location: ./application/controllers/support.php */