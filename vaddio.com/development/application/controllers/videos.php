<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends MX_Controller {

	 
	public function __construct() {
        parent::__construct(); 				
	}


	public function index(){
		set_title("Videos");
		//set_keywords("keywords go here");
		//set_metadescription(str_replace("\n","",str_replace("\r","",strip_tags($content["marketDetail"]["description"]))));
		
		
		$this->load->helper('embedvideo_class');
		$this->load->helper('videothumbnail_class');
		//$this->output->css("js/fancybox/jquery.fancyboxRoundCorners-1.3.4.css");
		//$this->output->javascript("/js/fancybox/jquery.fancybox-1.3.4.pack.js");
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		$this->output->css("/css/video.css");
		
		$this->output->javascript("//cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js");
		$this->output->javascript("/js/videos.js");
		
		$this->load->model('videos_model');
		
		$content = array();
		
		$this->load->model('videos_model');
		$content["featured"] = $this->videos_model->getFeaturedVideo();
		$content["categories"] = $this->videos_model->getVideoCategories(0,true,true);
		$content["recent"] = $this->videos_model->getRecentVideos();
		$content['allVideos'] = $this->videos_model->getAllVideos();
	
		// create the output for the featured video.
		$embedder = new embedVideo();
		//$embedder->setFixedWidth(567);
		$embedder->showThumbnail(false);
		$embedder->autoPlay(false);		
		if(count($content["featured"]) > 0){
			$content["featured_video_output"] = $embedder->embedVideoByDbRow($content["featured"]);
		}
				

        for($i=0; $i < count($content['allVideos']); $i++){
			$vid = new VideoThumbnail();
			$content['allVideos'][$i]['output'] =$vid->placeThumbnailByDatabaseRow($content['allVideos'][$i]);
        }
		
        for($i=0; $i < count($content['recent']); $i++){
			$vid = new VideoThumbnail();
			$content['recent'][$i]['output'] = $vid->placeThumbnailByDatabaseRow($content['recent'][$i]);
        }

		
		//$this->load->model('video_model');		
		$data['bodyClass'] = "videos";
		$data['content'] = $this->load->view('videos/videos_view', $content, true);			
		$this->load->view('templates/main_template', $data);
	}
	
	
	
	
	
	public function category($slug) {
		
		$this->load->helper('embedvideo_class');
		$this->load->helper('videothumbnail_class');
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		$this->output->css("/css/video.css");

		$this->output->javascript("//cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js");
		$this->output->javascript("/js/videos.js");

		$content = array();

		$this->load->model('videos_model');
		$cat_id = $this->videos_model->getCategoryID($slug);
		if ($cat_id == "") die("404");
		$content["videos"] = $this->videos_model->getVideosInCategory($cat_id);
		$content["category_info"] = $this->videos_model->getCategory($cat_id);
		$content["categories"] = $this->videos_model->getVideoCategories(0,true,true);
		
		// create the output for the featured video.
		$embedder = new embedVideo();
		$embedder->showThumbnail(false);
		$embedder->autoPlay(false);
		
		for($i=0; $i < count($content["videos"]); $i++){
			$vid = new VideoThumbnail();
			$content["videos"][$i]["output"] = $vid->placeThumbnailByDatabaseRow($content["videos"][$i]);
		}
		
		set_title($content["category_info"]->cat_name . " Videos");
				
		$data['bodyClass'] = "videos-category";
		$data['content'] = $this->load->view('videos/videos_category_view', $content, true);			
		$this->load->view('templates/main_template', $data);
		
	}
	
	
	
	
	
	public function all(){
		
		set_title("All Videos");
        //set_keywords("keywords go here");
		//set_metadescription(str_replace("\n","",str_replace("\r","",strip_tags($content["marketDetail"]["description"]))));
		
		$this->load->helper('embedvideo_class');
		$this->load->helper('videothumbnail_class');
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		$this->output->css("/css/video.css");
		
		$this->output->javascript("//cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js");
		$this->output->javascript("/js/videos.js");
		
		$this->load->model('videos_model');
		
		$content = array();
		
		$this->load->model('videos_model');
		$content['allVideos'] = $this->videos_model->getAllVideos();
		$content["categories"] = $this->videos_model->getVideoCategories(0,true,true);
	
		// create the output for the featured video.
		$embedder = new embedVideo();
		//$embedder->setFixedWidth(567);
		$embedder->showThumbnail(false);
		$embedder->autoPlay(false);		

          for($i=0; $i < count($content['allVideos']); $i++){
			$vid = new VideoThumbnail();
			$content['allVideos'][$i]['output'] =$vid->placeThumbnailByDatabaseRow($content['allVideos'][$i]);
          }

		
		//$this->load->model('video_model');		
		$data['bodyClass'] = "all-videos";
		$data['content'] = $this->load->view('videos/videos_all_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}


	public function search($search_for){
	
		set_title("Videos : Search Results");
        //set_keywords("keywords go here");
		//set_metadescription(str_replace("\n","",str_replace("\r","",strip_tags($content["marketDetail"]["description"]))));
		
		$this->load->helper('embedvideo_class');
		$this->load->helper('videothumbnail_class');
		$this->output->css("/js/fancybox2/jquery.fancybox.css");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.pack.js");
		$this->output->css("/css/video.css");
		
		$this->output->javascript("//cdn.jquerytools.org/1.2.7/tiny/jquery.tools.min.js");
		$this->output->javascript("/js/videos.js");
		$this->output->javascript('/js/jquery/jquery.highlight.js');	
		
		
		$this->load->model('videos_model');
		
		$content = array();	
		
		$this->load->model('search_model');
		$content['searchFor'] = urldecode($search_for);
		$content['searchTermArray'] =  $this->search_model->searchstring_to_array($search_for);
		
		$content['searchTermsDisplay'] = array();
		foreach($content['searchTermArray'] as $st){
			array_push($content['searchTermsDisplay'],"<span class='searchTerm'>&ldquo;" . $st . "&rdquo;</span>");
		}

			
		$this->load->model('videos_model');
		$content['allVideos'] = $this->search_model->search_videos($search_for);
		$content["categories"] = $this->videos_model->getVideoCategories(0,true,true);
	
		// create the output for the featured video.
		$embedder = new embedVideo();
		$embedder->showThumbnail(false);
		$embedder->autoPlay(false);		

        for($i=0; $i < count($content['allVideos']); $i++){
			$vid = new VideoThumbnail();
			$content['allVideos'][$i]['output'] =$vid->placeThumbnailByDatabaseRow($content['allVideos'][$i]);
        }
		
		//$this->load->model('video_model');		
		$data['bodyClass'] = "search-videos";
		$data['content'] = $this->load->view('videos/videos_search_view', $content, true);			
		$this->load->view('templates/main_template', $data);
	}




	public function video($slug,$displayInPopup = false){
		
		$this->load->helper('EmbedVideo_class');
		$this->output->css("/css/video.css");
		$this->output->javascript("/js/videos.js");
		
		$data['bodyClass'] = "video-detail";
		$this->load->model('videos_model');
		$content = $this->videos_model->getVideo($slug);
		
		
		$content->categories = $this->videos_model->getVideoCategories(0,true,true);
		
		
		if(count($content) == 0){
			log_message('error', 'CUSTOM: Could not find video for slug = "'.$slug.'" at '.current_url());
			set_title("Video Not Found");
			$content["slug"] = $slug;
			$content["slug_not_found"] = true;
			$content["video_name"] = "Video Not Found";
		} else {
			set_title($content->video_name . " Video");
			//set_keywords("keywords go here");
			set_metadescription($content->video_summary);
			
			if(!($content)) show_404();
			
			$embedder = new embedVideo();
			$embedder->setFixedWidth(673);
			$embedder->showThumbnail(false);
			$embedder->autoPlay(true);
			
			$content->video_output = $embedder->embedVideoByDbRow($content);
		}
		$data['content'] = $this->load->view('videos/video_detail_view', $content, true);			
		$this->load->view('templates/main_template', $data);	

	}






	public function videoPopup($id){
		$this->load->helper('EmbedVideo_class');
		
		$this->output->css("/css/video.css");
		
		$data['bodyClass'] = "video-popup";
		$this->load->model('videos_model');
		$content = $this->videos_model->getVideoByID($id);
		
		//if(!($content)) show_404();
		
		$embedder = new embedVideo();
		$embedder->setFixedWidth(567);
		$embedder->showThumbnail(false);
		$embedder->autoPlay(true);
		
		$content->video_output = $embedder->embedVideoByDbRow($content);
				
		
		$data['content'] = $this->load->view('videos/video_popup_view', $content, true);			
		$this->load->view('templates/popup_template', $data);	
		
	}


	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */