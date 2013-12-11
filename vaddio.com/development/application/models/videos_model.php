<?php
class Videos_model extends MY_Model {	

	public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }


	public function getProductVideos($product_id){
		return $this->getVideos('video_order',$product_id);
	}
	public function getAllVideos(){
		return $this->getVideos('video_order',NULL,NULL,NULL);
	}
	public function getRecentVideos($count = 12){
		return $this->getVideos('video_id DESC',NULL,NULL,$count);
	}
	public function getHomepageVideos(){
		return $this->getVideos('homepage_order',NULL,NULL,4);
	}
	public function getVideosInCategory($cat_id){
		return $this->getVideos('video_order',NULL,$cat_id);
	}
	
	private function getVideos($order = 'video_order',$product_id = NULL,$category_id = NULL,$count = NULL){		  
		
		if($count){
			$this->db->limit($count);
		}
		
		if($product_id){
			$this->db->join('product_video_matches m','m.video_id = v.video_id','left');
			$this->db->where('m.product_id', $product_id);
		}
		
		if($category_id){
			$this->db->where('v.video_category', $category_id);
		}
		
		if($order == 'homepage_order') $this->db->where('homepage_order > 0');	
		
		$q = $this->db->select('*')
					  ->where('isActive', 1)
					  ->order_by($order)
					  ->get("product_videos v");	
			
		$Results = $q->result_array();	
			
		return $Results;
	}
	
	
	
	public function getVideo($slug){		
		$q = $this->db->select('*')
				  ->where('slug',$slug)
				  ->get("product_videos");				
		$Results = $q->row();			
		return $Results;
	}
	public function getVideoByID($id){		
		$q = $this->db->select('*')
				  ->where('video_id',$id)
				  ->get("product_videos");				
		$Results = $q->row();	
		return $Results;
	}
	
	
	
	public function getFeaturedVideo(){		
		$q = $this->db->select('*')
				  ->where('featured_video',1)
				  ->get("product_videos");				
		$Results = $q->row();			
		return $Results;

	}
	
	public function getVideoCategories($cat_parent = 0,$return_sub_categories=true,$return_videos=false){
		$q = $this->db->select('cat_id,slug,main_image,secondary_image,cat_description,cat_name')
				  ->where('cat_parent',$cat_parent)
				  ->where('isActive',1)
				  ->order_by('cat_order')
				  ->get("video_categories");				
		$Results = $q->result_array();
		for($i=0; $i < count($Results); $i++){
			if($return_sub_categories) $Results[$i]['children'] = $this->getVideoCategories ($Results[$i]['cat_id'],$return_sub_categories,$return_videos);
			if($return_videos)		   $Results[$i]['videos']   = $this->getVideosInCategory($Results[$i]['cat_id']);
		}
		return $Results;

	}
	
	public function getCategoryID($slug) {
		$q = $this->db->select("cat_id")
				  ->where("slug",$slug)
				  ->get("video_categories");				
		$Results = $q->row();
		return $Results->cat_id;
	}
	
	public function getCategory($cat_id) {
		$q = $this->db->select("cat_id,slug,main_image,secondary_image,cat_description,cat_name")
				  ->where("cat_id",$cat_id)
				  ->get("video_categories");				
		$Results = $q->row();
		return $Results;
	}
	

}