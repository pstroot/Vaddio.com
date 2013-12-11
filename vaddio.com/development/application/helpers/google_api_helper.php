<?php
class googleApiHelper
{
	// SEE application/config/{ENVIRONMENT]/config.php for the google calendar access settings
	private $apiKey;
	private $googleCalendarUser;
	private $googleCalendarPassword;	
	
	public function __construct($calendarConfig = NULL) { // if $googleCalendarData is passed in, ignore the connection to CodeIgniter. This could happen if this class is being called from outside of codeIgniter(i.e. the admin section)
		if(!isset($calendarConfig)){
			$CI =& get_instance();
			$calendarConfig =  @$CI->config->item('googleCalendar');
		}
		$this->apiKey =$calendarConfig['apiKey'];
		$this->googleCalendarUser = $calendarConfig['user'];
		$this->googleCalendarPassword = $calendarConfig['password'];
    }
	
	public function connect(){
		Zend_Loader::loadClass('Zend_Gdata');

		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

		Zend_Loader::loadClass('Zend_Gdata_Calendar');
		$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;

		$client  = Zend_Gdata_ClientLogin::getHttpClient($this->googleCalendarUser, $this->googleCalendarPassword, $service);

		$gdataCal = new Zend_Gdata_Calendar($client);	

		return $gdataCal;
	}
	
	public function getKey(){
		return $this->apiKey;	
	}
}






















////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// HELPER METHODS //////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////



function createDescription($data,$roomString){
	$description = "";
	if(count($data["calendar_data"]) > 1){
		$description .= "Multipe Rooms: " . $roomString .  "\n";
	} else {
		$description .= "Room: " . $roomString .  "\n";
	}
	
	// Depreciated //  
	/*
	$description = "System(s): " . $data["products"] . "\n";
	if($data["type_of_application"] != ""){
		$description .= "Type of Application: " . stripslashes($data["type_of_application"]) . "\n";
	}
	if(isset($data["delivery_method"]) && $data["delivery_method"] != ""){
		$description .= "Delivery Method: " . stripslashes($data["delivery_method"]) . "\n";
	}
	if($data["type-of-connection"] != ""){
		$description .= "Call Connection: " . stripslashes($data["type-of-connection"]) . "\n";
	}
	$description .= "Attendee(s): " . implode(", ",$data["person"]) . "\n";
	$description .= "START: " . date_format(date_create($data["startTime"]), "M j, g:i a") . "\n";
	$description .= "END: " . date_format(date_create($data["endTime"]), "M j, g:i a") . "\n";
	*/
	
	$description .= "Dealer Name: " . stripslashes($data["dealer_or_user_name"]) . "\n";
	$description .= "Contact Name: " . stripslashes($data["contact_name"]) . "\n";
	$description .= "Company: " . stripslashes($data["company"]) . "\n";
	$description .= "Website: " . stripslashes($data["website"]) . "\n";
	$description .= "Address: " . stripslashes($data["address"]) . "\n";
	if($data["address2"] != ""){
		$description .= " " . $data["address2"] . "\n";
	}
	$description .= " " . $data["city"] . ", " . $data["state"] . " " . $data["zip"] . "\n";
	$description .= "Office Phone: " . $data["phone_office"] . "\n";
	if($data["phone_mobile"] != ""){
		$description .= "Mobile Phone: " . $data["phone_mobile"] . "\n";
	}
	if($data["phone_fax"] != ""){
		$description .= "Fax: " . $data["phone_fax"] . "\n";
	}
	$description .= "Email: " . $data["email"] . "\n";
	if($data["website"] != ""){
		$description .= "Website: " . $data["website"] . "\n";
	}
	$description .= "Comments: " . stripslashes($data["comments"]) . "\n";
		
	return $description;	
}



function createNewEvent($gdataCal,$calendar_data,$description){
	
    try {
		$newEvent = $gdataCal->newEventEntry();
    } catch (Zend_Gdata_App_Exception $e) {
		//$errors["calendar"] = "There was an error creating a new event entry";		
		return NULL;
    }
	
	$newEvent = populatEventData($newEvent,$calendar_data,$description);
		
	try {
		$uri = "http://www.google.com/calendar/feeds/" . $calendar_data->calendar_id . "/private/full";
		$event = $gdataCal->insertEvent($newEvent,$uri);	
    } catch (Zend_Gdata_App_Exception $e) {
		//$errors["calendar"] = "There was an error inserting a new event";		
		return NULL;
    }
	
	return $event;
	
}


function populatEventData($gdataCal,$event,$calendar_data,$description){
	
    // Populate the event with the desired information
    // Note that each attribute is crated as an instance of a matching class
   // $event->title = $gdataCal->newTitle($data["Company"] . " (".$data["Contact_name"].")");
    $event->title = $gdataCal->newTitle("Pending");
    $event->content = $gdataCal->newContent($description);
	// set attendees
	//$who = $gcal->newwho();
	//$who->setEmail('myEm...@myDomain.com');
	//$event->setWho(array($who));
     
    $when = $gdataCal->newWhen();
    $when->startTime = $calendar_data->start;
    $when->endTime = $calendar_data->end;
    $event->when = array($when);

	return $event;
}





function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}






