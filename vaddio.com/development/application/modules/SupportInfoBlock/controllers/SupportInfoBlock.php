<?php     
/*
This module creates blocks of information. 
These block appear on the support pages in the right column
*/

class SupportInfoBlock extends MX_Controller {

	 public function __construct() {
        parent::__construct();   
        //$this->lang->load("module_top_nav");
		//$this->output->javascript("/js/find_products.js");
		$this->output->css("/css/supportInfoBlock.css");
    }
	
	
	
	function index($whichBlock = 'contact') {	
		if($whichBlock == 'contact')  $this->contact();
		if($whichBlock == 'warranty') $this->warranty();
		if($whichBlock == 'product support') $this->product_support();
		if($whichBlock == 'helpful links') $this->helpful_links();
		if($whichBlock == 'vaddio loader') $this->vaddio_loader();
		
		
		$this->load->model('category_model');
		$data["top_categories"] = $this->category_model->getChildCategories(NULL, false);
		
		$this->load->model('markets_model');	
		$data["markets"] = $this->markets_model->getMarkets();
					
	}
	
	
	public function contact(){
		$this->load->model('content_model');
		$data["phone"] = $this->content_model->getContact('Phone');
		$data["tollfree"] = $this->content_model->getContact('Toll Free');
		$data["supportemail"] = $this->content_model->getContact('Support Email');
		$data["contacttext"] = $this->content_model->getContact('Contact Text');
		$data["whichBlock"] = 'contact';	
		$this->load->view('SupportInfoBlock_view',$data);
	}
	
	
	public function warranty(){
		$this->load->model('doc_library_model');	
		$data["warranty"] = $this->doc_library_model->getDocLibraryPlacement('warranty');
		$data["whichBlock"] = 'warranty';	
		$this->load->view('SupportInfoBlock_view',$data);
	}
	
	
	
	
	public function vaddio_loader(){
		$this->load->model('doc_library_model');	
		$results = $this->doc_library_model->getVaddioLoaderFiles();
		
		$data["vaddio_loader_instructions_name"] = $results["vaddio_loader_instructions"][0]["name"];
		$data["vaddio_loader_instructions_link"] = $results["vaddio_loader_instructions"][0]["path"];
        $data["vaddio_loader_instructions_filetype"] = $results["vaddio_loader_instructions"][0]["type"];
        $data["vaddio_loader_instructions_filesize"] = $results["vaddio_loader_instructions"][0]["size"];
		
		$data["vaddio_loader_name"] = $results["vaddio_loader"][0]["name"];
		$data["vaddio_loader_link"] = $results["vaddio_loader"][0]["path"];
        $data["vaddio_loader_filetype"] = $results["vaddio_loader"][0]["type"];
        $data["vaddio_loader_filesize"] = $results["vaddio_loader"][0]["size"];
				
		$data["whichBlock"] = 'vaddio loader';	
		$this->load->view('SupportInfoBlock_view',$data);
	}
	
	
	public function helpful_links(){
		$this->load->model('doc_library_model');	
		$data["warranty"] = $this->doc_library_model->getDocLibraryPlacement('warranty');
		$data["whichBlock"] = 'helpful links';	
		$this->load->view('SupportInfoBlock_view',$data);
	}
	
	
	public function product_support(){
		$this->load->model('product_model');
		
		$data["allProducts"] = array();
		$data["allProducts"][] = "Select a Product";
		$products = $this->product_model->getProductList('p.product_name');
		
		
		foreach($products as $p){
			$data["allProducts"][$p["slug"]] = $p["product_name"];
		}
	
		$data["selectedProduct"] = end($this->uri->segment_array());
		
		$data["whichBlock"] = 'product support';	
		$this->load->view('SupportInfoBlock_view',$data);
	}
	

}