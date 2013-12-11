<?php     
class FindProducts extends MX_Controller {
  

	public $autoload = array(
        //'helpers'   => array('url', 'form'),
        //'libraries' => array('javascript'),
    );
	

	 public function __construct() {
        parent::__construct();   
        /* $this->lang->load("module_find_products"); */
		$this->output->javascript("/js/jquery/jquery.selectBoxIt.min.js");
		$this->output->css("/css/jquery.selectBoxIt.css");
		
		$this->output->javascript("/js/find_products.js");
		$this->output->css("/css/find_products.css");
		
		if(strtolower($this->uri->segment(1)) == "product"){
			$this->product_to_show = $this->uri->segment(2);
		}
		if(strtolower($this->uri->segment(1)) == "category"){
			$this->category_to_show = $this->uri->segment(2);
		}
		
    }
	
	public function index() {
		$data = array();
		$this->load->model('FindProducts_model');
		
		// gets an alphabetical list of all products
		$data["products"] = $this->FindProducts_model->getProductList();
			
		// gets an nested array of all categories and products
		$data["category_list"] = $this->getCategoryAndChildrenList();	
		
			
		$this->load->view('FindProducts_view',$data);
			
	}
	
	


	
	
	function getCategoryAndChildrenList($parent_id = NULL){
		
		$data = $this->FindProducts_model->getChildCategories($parent_id);
		
		if(count($data) == 0) return;
		
		$output = '<ul class="fp-cats">';
		
		foreach($data as $cat){
			$isCategoryActive = '';
			if(isset($this->product_to_show)){
				$isCategoryActive = $this->itemContainsChild($this->product_to_show,$cat) ? "active" : "";
			} else if(isset($this->category_to_show)){
				$isCategoryActive = $this->itemContainsChild($this->category_to_show,$cat) ? "active" : "";
			}
			
			$output .= '<li class="fp-cat fp-cat-'.$cat["slug"].' fp-cat-'.$cat["cat_id"].' ' . $isCategoryActive . '">';
			$output .= '<a href="' . base_url() . 'category/'.$cat["slug"].'">' . stripslashes($cat["name"]).'</a>';
			
			// get a list of products under this category
			if(isset($cat["products"]) && count($cat["products"]) > 0){
				$output .= '<ul class="fp-products">';
				foreach($cat["products"] as $product){
					$isProductActive = (isset($this->product_to_show) && $product['slug'] == @$this->product_to_show) ? "active" : "";
					$output .= '<li class="fp-product fp-product-'.$product["slug"].' fp-product-'.$product["product_id"].' ' . $isProductActive . '"><a href="/product/'.$product["slug"].'">'.stripslashes($product["product_name"]).'</a></li>';
				}
				$output .= '</ul>';
			}
			
			// get a list of sub-categories under this category
			$output .= $this->getCategoryAndChildrenList($cat["cat_id"]);
			
			$output .= '</li>';
			
		}
		$output .= '</ul>';
		return $output;		
	}
	
	
	
	function itemContainsChild($needle,$haystack){
		if($haystack['slug'] == $needle) return true;
		
		if(isset($haystack['products'])){
			foreach($haystack['products'] as $child){
				if(@$child['slug'] == $needle){
					return true;
				}
			}
		}
		if(isset($haystack['children'])){
			foreach($haystack['children'] as $childCat){
				if($this->itemContainsChild($needle,$childCat)) return true;
			}
		}
		
		return false;
	}
	
	

}