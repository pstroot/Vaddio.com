<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demos extends MX_Controller {


	public function __construct() {
        parent::__construct(); 		
		$this->output->css("/css/demos.css");			
	}


	public function index(){
		set_title("Request a VaddioLIVE Demo");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$content = array();		
		$data['bodyClass'] = "demos";
		$data['content'] = $this->load->view('demos_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}


	public function schedule(){
		set_title("Request a VaddioLIVE Demo");
		//set_keywords("keywords go here");
		//set_metadescription($content->description);
		
		$this->output->javascript("/js/jquery/jquery.animate-colors-min.js");
		//$this->output->javascript("/js/jquery/jquery.inputhints.js");
		//$this->output->javascript("/js/jquery/form_validation.js");
		$this->output->javascript("/js/jquery/jquery.dimensions.js");
		$this->output->javascript("/js/jquery/jquery.tooltip.js");
		$this->output->javascript("/js/JSON-js-master/json2.js");
		$this->output->javascript("/js/detectBrowser.js?v=1");
		$this->output->javascript("/js/demo_request_form.js");
		//$this->output->javascript("/js/fancybox/jquery.fancybox-1.3.4.pack.js");
		$this->output->javascript("/js/fancybox2/jquery.fancybox.js");
		//$this->output->css("/js/fancybox/jquery.fancybox-1.3.4.css?v=1");
		$this->output->css("/js/fancybox2/jquery.fancybox.css?v=1");

		$content = array();		
		
		$this->load->model('demos_model');	
		$content["rooms"] = $this->demos_model->getRooms();
		
		$this->load->model('content_model');
		
		$content["sendTo"] = $this->content_model->getContent("VaddioLIVE Daily Event Notification");
		//$content["sendTo"] = "paul@dancingpaul.com"; // for testing	

		$data['bodyClass'] = "demos-schedule";
		$data['content'] = $this->load->view('demos_schedule_view', $content, true);			
		$this->load->view('templates/main_template', $data);	
	}
	
	
	
	public function calendar($rooms,$timeslot_minutes = NULL){
		$this->load->helper('google_api');
		$gah = new googleApiHelper;
		
		$this->load->model('demos_model');	
		
		$showTheseRooms = explode("-",$rooms);
		$content["rooms"] = $this->demos_model->getRoomsByIDs($showTheseRooms);
				
		$content["googleAPI"] = $gah->getKey();
		$content["minTime"] = 8;
		$content["maxTime"] = 17;
		$content["increment"] = (isset($timeslot_minutes)) ? $timeslot_minutes : 60;
		
		date_default_timezone_set('America/Chicago');		
		$this->output->javascript("/js/fullcalendar/fullcalendar.js");	// FullCalendar v1.5.4, creates a calendar based on specified inputs.
		$this->output->javascript("/js/date.format.js");
		$this->output->javascript("/js/JSON-js-master/json2.js");
		$this->output->javascript("/js/demo_google_calendar.js");		// custom javascript for this Vaddio Calendar
		
		$this->output->css("/css/calendar/redmond/jquery-ui-1.8.23.custom.css");
		$this->output->css("/js/fullcalendar/fullcalendar.css");
		$this->output->css("/css/calendar/styles.css");
				
		$data['bodyClass'] = "demos-calendar";
		$data['content'] = $this->load->view('demos_calendar_view', $content, true);			
		$this->load->view('templates/popup_template', $data);	
	}
	
	
	
	
	public function ajax_insert_pending_calendar_event(){
		$returnArray = array();
		$calendar_id = $this->input->get('calendar_id');
		$startTime = $this->input->get('start');
		$endTime = $this->input->get('end');
		$label = $this->input->get('label');
		$label = "Temporary Hold";
		
		
		// CONNECT TO GOOGLE CALENDAR		
		$this->load->helper('zend_framework');
		$this->load->helper('google_api');		
		$gah = new googleApiHelper;
		$gdataCal = $gah->connect();
		
		$query = $gdataCal->newEventQuery();
		$query->setUser('default');
		$query->setVisibility('private');
		
		// Create a new entry using the calendar service's magic factory method
		$event = $gdataCal->newEventEntry();
			 
		// Populate the event with the desired information
		// Note that each attribute is crated as an instance of a matching class
		$event->title = $gdataCal->newTitle($label);
		$event->where = array($gdataCal->newWhere("Vaddio"));
		
		//$event->content = $service->newContent($_COOKIE["userID"]);
		$event->content = $gdataCal->newContent("Pending Request Submitted at " . date('g:i A')); 
		$when = $gdataCal->newWhen();
		$when->startTime = $startTime;
		$when->endTime = $endTime;
		$event->when = array($when);
		
		// Upload the event to the calendar server
		// A copy of the event as it is recorded on the server is returned
		$uri = "http://www.google.com/calendar/feeds/".$calendar_id."/private/full"; 
		
		$newEvent = $gdataCal->insertEvent($event,$uri);	
		
		$returnArray["room_name"] = $newEvent->who[0]->valueString;
		$returnArray["event_id"] = $newEvent->id->text;
		$returnArray["event_label"] = $newEvent->title->text;
		$returnArray["start"] = $newEvent->when[0]->startTime;
		$returnArray["end"] = $newEvent->when[0]->endTime;		
		$returnArray["result"] = "success";
		
		echo json_encode($returnArray);		
		
	}
	
	


	public function ajax_remove_pending_events(){
 		//$this->nxs_cURLTest("https://www.google.com/intl/en/contact/", "HTTPS to Google", "Mountain View, CA");
 
 
		$verbose = false;
		
		$this->load->model('demos_model');	
		$rooms = $this->demos_model->getRooms();
		
		ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.str_replace("/", "\\", BASEPATH)."libraries\\");
		$this->load->helper('zend_framework');
		$this->load->helper('google_api');
		$gah = new googleApiHelper;
		$gdataCal = $gah->connect();
		
		
		// GET THE GMT TIME FOR 15 MINUTES AGO
		$offset=15*60; //converting 15 minutes to seconds.
		$dateFormat="Y-m-d\TH:i:s T";
		$timeNdate=gmdate($dateFormat, time()-$offset);
		
		if($verbose) print "Remove Pending Events older than  for Calendar " . date("m/d/Y g:i A",strtotime($timeNdate)) . "\n";
		 
		foreach($rooms as $room){
		  	$calID = $room["calendar_id"];
			if($verbose) print "Remove Events for Calendar " . $calID . "\n";		  
			
			$query = $gdataCal->newEventQuery();
			$query->setUser(urlencode($calID));
			$query->setVisibility('private');
			$query->setProjection('full');
			$query->setStartMin(date("Y-m-d",strtotime("-1 week")));// start with last week
			$query->setStartMax(date("Y-m-d",strtotime("+1 week")));// start with last week
			$query->setQuery("Temporary Hold");
		
			try {
				$eventFeed = $gdataCal->getCalendarEventFeed($query);
				if($verbose) print "-> Found Event Feed\n";
			} catch (Zend_Gdata_App_Exception $e) {
				if($verbose)  "Error retrieving calendar $calID<BR>\n";
				continue;
			}
		
			if($verbose) print "-> ".count($eventFeed)." Events named 'Temporary Hold' \n";
		
			foreach ($eventFeed as $event) {
				//$event->title
				//$event->when[0]
				//$event->id
				if($verbose) print "-> Event modified at ".date("g:i A",strtotime($event->updated))."\n";		
				try {
					if(strtotime($event->updated) < strtotime($timeNdate)){
						try {					
							if($verbose) print "-> Deleting event '". $event->title . "' in Calendar " . $eventFeed->title->text . "<BR>\n";
							$event->delete();
						} catch (Zend_Gdata_App_Exception $e) {
							if($verbose) print  "-> Error deleting event " . $event->title . " (ID: ".$event->id." TIME: " . $event->when[0] . ")<BR>\n";
						}
					} else {
						if($verbose) print "-> ".date("g:i A",strtotime($event->updated))." >= ".date("g:i A",strtotime($timeNdate))."\n";			
					}
				} catch (Zend_Gdata_App_Exception $e) {
					if($verbose) print  "-> Error getting event " . $event->title . " (ID: ".$event->id." TIME: " . $event->when[0] . ")<BR>\n";
					continue;
				}
			}
			if($verbose) print "\n";
		
		}
		
	}
	
	
	
	
	
	
	
	
	public function ajax_calendar_submit(){
		
		$this->load->library('form_validation');
		
		// initialize an some arrays that we will use to return JSON output. Much of the info returned will be for debugging.
		$returnArray = array();
		$returnArray["actions"] = array(); 		
		$errors = array();
		$warnings = array();
		
		// Set validation rules. Javascript should have already caught all of this, so this is just a backup. See the method "getValidationRules()" lower down on this page.
		$this->form_validation->set_rules($this->getValidationRules()); 
		
		if($this->form_validation->run() == false) {
			// if validtion failes, display error output.
			$returnArray["result"] = "error";
			$returnArray["errors"] = validation_errors();
			print json_encode($returnArray);
			exit();
		}
			
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////// FORMAT TIME AND TIMEZONES ////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$startTime = $this->input->post("startTime"); // In GMT Time, i.e. 2014-02-04T17:00:00.000Z (note that there is no offset indicated.
		$endTime = $this->input->post("endTime");
		$startTimeTimezone = $this->input->post("startTimeTimezone");
		$calendar_data = $this->input->post("calendar_data");
 
		//$startTime = substr($startTime,0,count($startTime)-7) . "-06:00";	
		//$endTime = substr($endTime,0,count($endTime)-7) . "-06:00";	
		
		$data["startTimeTimezone"] = "Central Time";  
		$calendar_data = json_decode(stripslashes($calendar_data));
		
		
		
		// Create a string out of our rooms that were selected.
		$roomString = "";
		if(count($calendar_data) > 0){
			for($i=0; $i < count($calendar_data); $i++){
				if($i > 0 && $i == count($calendar_data)-1) $roomString .= " and ";
				else if ($i > 0)  $roomString .= ", ";			
				$roomString .= $calendar_data[$i]->room_name;
			}
		}
		
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////// UPDATE THE GOOGLE CALENDAR ////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$this->load->helper('zend_framework');
		$this->load->helper('google_api');
		$gah = new googleApiHelper;
		$gdataCal = $gah->connect();
		
		$description = createDescription($this->input->post(),$roomString);					// from google_api_helper.php
		
		for($i=0; $i < count($calendar_data); $i++){
			$thisCal = $calendar_data[$i];
			try {
				$event = $gdataCal->getCalendarEventEntry($thisCal->event_id);				
				$event = populatEventData($gdataCal,$event,$thisCal,$description); 	// from google_api_helper.php
				$event->save();
				$returnArray["actions"][] = "Event Updated";
			} catch (Zend_Gdata_App_Exception $e) {
				//echo "COULD NOT POPULATE EVENT DATA\n";
				createNewEvent($gdataCal,$thisCal,$description); 					// from google_api_helper.php
				$returnArray["actions"][] = "New Event Created";
			}
		}	
		
		
	
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////// INSERT INTO THE DATABASE ////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		$calendars = array();			
		$insertThis = array(
			   'date_start' => date("Y-m-d G:i:s",strtotime($startTime)) ,
			   'date_end' => date("Y-m-d G:i:s",strtotime($endTime)) ,
			   'uID' => createRandomPassword(), // from google_api_helper.php
			   'name' => $this->input->post("dealer_or_user_name"),
			   'contact_name' => $this->input->post("contact_name"),
			   'company' => $this->input->post("company"),
			   'website' => $this->input->post("website"),
			   'address' => $this->input->post("address"),
			   'address2' => $this->input->post("address2"),
			   'city' => $this->input->post("city"),
			   'state' => $this->input->post("state"),
			   'zip' => $this->input->post("zip"),
			   'phone_office' => $this->input->post("phone_office"),
			   'phone_mobile' => $this->input->post("phone_mobile"),
			   'phone_fax' => $this->input->post("phone_fax"),
			   'email' => $this->input->post("email"),
			   //'manufacturer_rep_name' => $this->input->post("manufacturer_rep_name"),
			   'status' => "pending",
			   'comments' => $this->input->post("comments"),
			   'calendar_id' => $this->input->post("calendar_ids"),
			   'calendar_keys' => $this->input->post("room_ids"),
			   'calendar_names' => $this->input->post("room_names"),
			   'calendar_data' => base64_encode(serialize($calendar_data))
		);
		$this->db->insert('demo_requests', $insertThis);
		$inserted_id = $this->db->insert_id();
		$returnArray["inserted_id"]	 = $inserted_id;
		
		
		// used in both emails
		$theDate = date("M j", strtotime($startTime));
		$theTime = date( "g:i a", strtotime($startTime)) . " - " .  date( "g:i a", strtotime($endTime));
		
				
	
		////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////// SEND EMAIL TO ADMIN /////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////

		$POST_data = $this->input->post();
		$this->load->library('email');
		
		$msg = "There has been a demo request made through the website.\n\n";
		$msg .= "Date/Time: ".$theDate . " " . $theTime ."\n";		
		$msg .= stripslashes(createDescription($POST_data,$roomString));	
		$msg .= "\n\nTo approve or delete this request, go to " . base_url() . "admin/demo_details.php?id=" . $inserted_id;
		
		$this->email->from('no_reply@vaddio.com', 'Automated Email from Vaddio.com');
		$this->email->to($this->input->post("sendTo"));
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
			
		$this->email->subject('[website] Demo Request');
		$this->email->message($msg);
		if ( ! @$this->email->send()){
			$warnings[] = "Your demo has been scheduled, but there was a problem sending a notification email to one of our administrators. You may want to send an email to us at registration@vaddio.com and alert us of this message.";
		} else {
			$returnArray["actions"][] = "Email sent to administrator";
		}
		
		
		
		
		
		if (!count($errors)){
			////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////// SEND EMAIL TO USER /////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////
		
					
			$msg = "Hello,
				
Thanks for requesting a VaddioLIVE demo! We're reviewing the details of your request and will contact you shortly to confirm your time slot and provide instructions for connecting to the demo.
		
Time: {DATE}, {TIME} - {TIMEZONE}
Rooms: {ROOMS}
Contact Name: {NAME}
Comments: {COMMENTS}
		
NOTE: This demo is scheduled in {TIMEZONE}. Please adjust accordingly. 
If you need to reschedule, contact Bernadette Yard at byard@vaddio.com or Stacy Kringlen at skringlen@vaddio.com.
		
Best,
Vaddio Training Team
Bernadette Yard";
		
				
				$msg = str_replace("{NAME}",$POST_data["contact_name"],$msg);
				$msg = str_replace("{COMPANY}",$POST_data["company"],$msg);
				$msg = str_replace("{DATE}",$theDate,$msg);
				$msg = str_replace("{TIME}",$theTime,$msg);
				$msg = str_replace("{ROOMS}",$roomString,$msg);
				$msg = str_replace("{COMMENTS}",$POST_data["comments"],$msg);
				// DEPRECIATED // $msg = str_replace("{PRODUCTS}",$data["products"],$msg);
				// DEPRECIATED // $msg = str_replace("{APPLICATION}",$data["type_of_application"],$msg);
				// DEPRECIATED // $msg = str_replace("{ATTENDEES}",implode("; ",$data["person"]),$msg);
				// DEPRECIATED // $msg = str_replace("{NBR_ATTENDEES}",count($data["person"]),$msg);
				// DEPRECIATED // $msg = str_replace("{TYPE_OF_CONNECTION}",$data["type-of-connection"],$msg);
				$msg = str_replace("{TIMEZONE}",$POST_data["timezone"],$msg);
				
				$msg = stripslashes($msg);
				
				if(isset($data["delivery_method"]) && $POST_data["delivery_method"] != ""){
					if(isset($data["delivery_method_data"]) && $POST_data["delivery_method_data"] != ""){
						$platform = $data["delivery_method"] . ", " . $POST_data["delivery_method_data"];
					} else {
						$platform = $data["delivery_method"] . ", " . $POST_data["delivery_method_data"];
					}
				} else {
					$platform = "We will contact you to discuss your platform requirements.";
				}
					
				$msg = str_replace("{PLATFORM}",$platform,$msg);
					
		
			if(isset($msg)){
				$this->email->from('registration@vaddio.com', 'Vaddio.com Registration');
				$this->email->to($this->input->post("email"));
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				
			
				$this->email->subject('VaddioLIVE Request Submission');
				$this->email->message($msg);
		

					
				if ( ! @$this->email->send()){
					$warnings[] = "We were not able to send a confirmation email to you at  " . $this->input->post("email") . ". Please consider this message your confirmation. If you need to contact us about this demo please contact us at registration@vaddio.com";
				} else {
					$returnArray["actions"][] = "Email sent to user at " . $this->input->post("email");
				}
			}
		}
		
		
		// ALL DONE. PRINT THE JSON RESPONSE TO THE SCREEN
		if (!count($errors)){
			$returnArray["result"] = "success";
			//$returnArray["responseMessage"] = str_replace("\r\n","<BR>",$msg);
		} else {	
			$returnArray["result"] = "error";
			$returnArray["errors"] = $errors;
		}
		$returnArray["warnings"] = $warnings;
		print json_encode($returnArray);
		

	
		
	}
	
	
	
	
	
	
	
	
	
	
	// For submitting the form when completing the demo request process
	private function getValidationRules(){
		$config = array(
			   array(
					 'field'   => 'startTime',
					 'label'   => 'Start Time',
					 'rules'   => 'required'
				  ),
			   array(
					 'field'   => 'endTime',
					 'label'   => 'End Time',
					 'rules'   => 'required'
				  ),
			   array(
					 'field'   => 'calendar_data',
					 'label'   => 'Calendar Data',
					 'rules'   => 'required'
				  )
		);
		return $config;
	}
		

	
	
}

/* End of file Certified_integrators.php */
/* Location: ./application/controllers/Certified_integrators.php */