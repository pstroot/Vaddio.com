<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 	
		$this->load->model('category_model');			
	}

	public function index(){
		
		set_title("Products");
		//set_keywords("keywords go here");
		//set_metadescription($content["summary"]);
		
		$this->output->javascript("/js/jquery/jquery.selectBoxIt.min.js");
		$this->output->css("/css/jquery.selectBoxIt.css");
		
		$this->output->javascript("/js/find_products.js");
		$this->output->css("/css/category.css");
		$content['category_list'] = $this->category_model->getCategories();
		
		// gets an alphabetical list of all products
		$this->load->model('Product_model');
		$content["products"] = $this->Product_model->getProductList("p.product_name");
		
		$data['bodyClass'] = "categories";
		$data['content'] = $this->load->view('categories_view', $content, true);	
		$this->load->view('templates/main_template', $data);	
	}




	public function categoryDetail($slug){
		$this->output->css("/css/category-detail.css");
		$category_data = $this->category_model->getCategoryDetail($slug);

		if(count($category_data) == 0){
			log_message('error', 'CUSTOM: Could not find category with slug = "'.$slug.'" at '.current_url());
			$content["slug_not_found"] = true;
			$content['slug'] = $slug;
			$content['headline'] = "Category Not Found";
			set_title("Category not found");
			//set_keywords("keywords go here");
			//set_metadescription(strip_tags($category_data->description));
		} else {
			
			set_title("Category : " . $category_data->name);
			//set_keywords("keywords go here");
			set_metadescription(strip_tags($category_data->description));
			
			$content['headline'] = $category_data->name;
			$content['description'] = $category_data->description;	
			$content['sub_categories'] = $this->category_model->getChildCategories($category_data->id);
			
			
			$this->load->model('product_model');
			$content['products'] = $this->product_model->getProducts($category_data->id);
			
			for($i=0; $i<=(count($content['sub_categories'])-1); $i++){
				$content['sub_categories'][$i]["products"] = $this->product_model->getProducts($content['sub_categories'][$i]["id"]);
			}
		}
		$content["slug"] = $slug;
		$data['bodyClass'] = "category-detail";
		$data['content'] = $this->load->view('category_detail_view', $content, true);		
		$this->load->view('templates/main_template', $data);	
	}
	
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */