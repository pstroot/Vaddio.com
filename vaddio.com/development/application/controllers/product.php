<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MX_Controller {

	public function __construct() {
        parent::__construct(); 		
		$this->load->model('product_model');			
	}

	public function index(){
		// This should not ever happen, a product slug must be passed in. Otherwise this page will be routed to category/index
	}

	public function productDetail($slug){
		$this->load->model('videos_model');
		$this->load->model('doc_library_model');
		$this->load->model('accessories_model');
		
		$this->output->css("/css/product-detail.css");
		$this->output->javascript("/js/product_detail.js");
		
		// fancybox for the "Compare PTZ Cameras button
		$this->output->javascript("/js/compare_ptz_cameras_popup.js");
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		
		
		$content = $this->product_model->getProductDetail($slug);
		
		if($content == ''){
			log_message('error', 'CUSTOM: Could not find product with slug = "'.$slug.'" at '.current_url());
			$content['slug'] = $slug;
			$content["slug_not_found"] = true;
			set_title("Product Not Found");
		} else {
			set_title($content["name"]);
			//set_keywords("keywords go here");
			set_metadescription($content["summary"]);
			
			$product_id = $content["id"];
			
			$content['product_number_full'] = showProductNumbers($content["product_nbr"],$content["product_nbr_label"],$content["product_addtl_nbrs"], false);
			
			$content['alt_images'] 	= $this->product_model->getImages($product_id);
			$content['videos'] 		= $this->videos_model->getProductVideos($product_id);
			$content['hasAccessories'] = $this->accessories_model->hasAccessories($product_id);
			$content['related'] 	= $this->product_model->getRelatedProducts($product_id);
			$content['systems'] 	= $this->product_model->getProductSystems($product_id);
			$content['systemIncludes'] 	= $this->product_model->getSystemsIncludes($product_id);
			$content['specs'] 		= $this->product_model->getProductSpecs($product_id);
			$content['features'] 	= $this->product_model->getProductFeatures($product_id);
			
			if($this->authorization->show_prices()){
				$content['showPrices'] = true;
			}
			
			if($content['show_ptz_camera_link'] == 1){
			//if($content['thisCatSlug'] == "high-definition-ptz-cameras" || $content['thisCatSlug'] == "standard-definition-ptz-cameras"){
				$content['showCameraComparisonLink'] = true;
				// fancybox for the "Compare PTZ Cameras button
				$this->output->javascript("/js/compare_ptz_cameras_popup.js");
				$this->output->css("/js/fancybox2/jquery.fancybox.css");
				$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
			}
			
			
			if(isset($content['parentSystems'])){
				$parentSystemsArray = array();
				foreach($content['parentSystems'] as $s){
					array_push($parentSystemsArray,"<a href='" . base_url() . "product/".$s["slug"]."'>" . $s["product_name"] . "</a>");
				}
				$content['parentSystemsString'] = implode(", ",$parentSystemsArray);
			}
		} // END if product not found
		
		$data['bodyClass'] = "products";
		$data['content'] = $this->load->view('product_detail_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	
	
	
	
	
	
	
	public function accessories($slug){
		$this->load->model('accessories_model');
		
		$this->output->css("/css/product-accessories.css");
		
		$content = $this->product_model->getProductDetail($slug);
		
		set_title("Accessories for " . $content["name"]);
		//set_keywords("keywords go here");
		//set_metadescription($content["summary"]);
		
		if(!($content)) show_404();
		
		$product_id = $content["id"];
		$content['product_number_full'] = showProductNumbers($content["product_nbr"],$content["product_nbr_label"],$content["product_addtl_nbrs"], false);
		$content['accessories'] = $this->accessories_model->getAccessories($product_id);
		
		$data['bodyClass'] = "accessories";
		$data['content'] = $this->load->view('product_accessories_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}
	
	
}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */