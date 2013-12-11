<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UnitTest extends MX_Controller {

	public function __construct() {
		
		$this->load->library('unit_test');
		$this->lang->load('unit_test');	
		
		$str = '<table style="width:100%; font-size:small; margin:10px 0; border-collapse:collapse; border:1px solid #CCC;">
				{rows}
					<tr>
					<th style="text-align: left; border-bottom:1px solid #CCC;">{item}</td>
					<td style="border-bottom:1px solid #CCC;">{result}</td>
					</tr>
				{/rows}
			</table>';
		$this->unit->set_template($str); 
        parent::__construct(); 			
	}


	public function index(){
		
		$this->load->model('events_model');	
		$events = $this->events_model->getEvents(NULL,4);
		
		$this->unit->run($events, 'is_array', 'Events returns an array');
		$this->unit->run(count($events), 4, 'returning four events','Based on the events array having four elements');
		
		$this->load->model('videos_model');	
		$videos = $this->videos_model->getVideos(NULL,4);
		$this->unit->run($videos, 'is_array', 'Videos returns an array');
		$this->unit->run(count($videos), 4, 'returning four videos','Based on the videos array having four elements');
		
		$this->load->model('markets_model');	
		$markets = $this->markets_model->getMarkets();
		$this->unit->run($markets, 'is_array', 'Markets returns an array');
		
		$this->load->model('press_model');	
		$news = $this->press_model->getHomepageNews();
		$this->unit->run($news, 'is_array', 'News returns an array');
		
	
		echo $this->unit->report();
	}




}

/* End of file home.php */
/* Location: ./application/controllers/home.php */