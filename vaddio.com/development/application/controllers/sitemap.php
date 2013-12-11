<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MX_Controller {

	
	public function __construct() {
        parent::__construct(); 				
	}

	public function index(){
		$this->echo_opening_xml();
		$this->echo_sitemap_regular();
		$this->echo_sitemap_support();
		$this->echo_closing_xml();
	}
	
	public function support_sitemap(){
		$this->echo_opening_xml();
		$this->echo_sitemap_support();
		//$this->echo_sitemap_regular();
		$this->echo_closing_xml();		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	private function echo_opening_xml(){
		header('Content-type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		echo "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	}
	private function echo_closing_xml(){
		echo "</urlset>";
	}
	
	
	
	
	
	
	
	
	
	
	
	private function echo_sitemap_regular(){				
		echo "<url><loc>" . base_url() . "</loc><priority>1</priority></url>\n";		
		echo "<url><loc>" . base_url() . "category</loc><priority>0.7</priority></url>\n";		
		echo "<url><loc>" . base_url() . "markets</loc><priority>0.7</priority></url>\n";		
		echo "<url><loc>" . base_url() . "videos</loc><priority>0.7</priority></url>\n";		
		echo "<url><loc>" . base_url() . "training</loc><priority>0.7</priority></url>\n";		
		echo "<url><loc>" . base_url() . "about</loc><priority>0.7</priority></url>\n";
		echo "<url><loc>" . base_url() . "press</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "case-studies</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "white-papers</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "events</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "promotions</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "careers</loc><priority>0.6</priority></url>\n";		
		echo "<url><loc>" . base_url() . "catalog</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "contact</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "partners</loc><priority>0.6</priority></url>\n";
		echo "<url><loc>" . base_url() . "login</loc><priority>0.6</priority></url>\n";
		echo implode("\n",$this->getMarkets());
		echo implode("\n",$this->getPress());
		echo implode("\n",$this->getCareers());
		echo implode("\n",$this->getTraining());
		echo implode("\n",$this->getVideos());
		echo implode("\n",$this->getCategories());
		echo implode("\n",$this->getProducts());			
	}
	
	
	
	
	private function echo_sitemap_support(){
		echo "<url><loc>" . $this->config->config["support_url"] . "</loc><priority>0.9</priority></url>";
		echo "<url><loc>" . $this->config->config["support_url"] . "products</loc><priority>0.6</priority></url>";
		echo "<url><loc>" . $this->config->config["support_url"] . "resources</loc><priority>0.6</priority></url>";
		echo implode("\n",$this->getSupportProducts());	
	}
	
	
	
	
	
	
	
	
	
	
	
	private function getCategories(){		
		$this->load->model('category_model');	
		$results = $this->category_model->getAll();		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "category/" . $results[$i]["slug"] . "</loc></url>";
		}		
		return $output;
	}
	
	
	private function getProducts(){		
		$this->load->model('product_model');	
		$results = $this->product_model->getProductList("product_name");		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "product/" . $results[$i]["slug"] . "</loc></url>";
		}		
		return $output;
	}
	
	
	private function getMarkets(){
		$this->load->model('markets_model');	
		$results = $this->markets_model->getMarkets();		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "markets/" . $results[$i]["slug"] . "</loc></url>";
		}
		return $output;
	}
	
	
	private function getVideos(){
		$this->load->model('videos_model');	
		$results = $this->videos_model->getAllVideos();		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "video/" . $results[$i]["slug"] . "</loc></url>";
		}
		return $output;
	}
	
	private function getTraining(){	
		$output = array();
		$output[] =  "<url><loc>" . base_url() . "/training/register/online</loc></url>";
		$output[] =  "<url><loc>" . base_url() . "/training/details/design</loc></url>";
		$output[] =  "<url><loc>" . base_url() . "/training/register/onsite</loc></url>";
		$output[] =  "<url><loc>" . base_url() . "/training/details/installation</loc></url>";
		$output[] =  "<url><loc>" . base_url() . "/training/details/installation#lodging</loc></url>";
		$output[] =  "<url><loc>" . base_url() . "/training/whyCertify</loc></url>";
		return $output;
	}
	
	private function getPress(){
		$this->load->model('press_model');	
		$results = $this->press_model->getAll();		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "press/" . $results[$i]["slug"] . "</loc></url>";
		}
		return $output;
	}
	
	private function getCareers(){
		$this->load->model('careers_model');	
		$results = $this->careers_model->getAll();		
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . base_url() . "careers/". $results[$i]["slug"] . "</loc></url>";
		}
		return $output;
	}
	
	
	private function getSupportProducts(){	
		$this->load->model('product_model');	
		$results = $this->product_model->getProductList("product_name")	;
		$output = array();
		for($i=0; $i<=(count($results)-1); $i++){
			$output[] =  "<url><loc>" . $this->config->config["support_url"] . $results[$i]["slug"] . "</loc><priority>0.5</priority></url>";
		}			
		return $output;
	}


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */