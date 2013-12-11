
$(document).ready(function() {
	var googleMapRoomIndex = 0;
	var minTime = 0;
	var maxTime = 0;
	
	var calendarData = new Array(); // an array of data objectes that will be retrieved from google calendar
	var roomsArray = _roomsArray /* this is set in demos_calendar_view.php */
	var times = new Array();// create a new array that will hold all of our timeslots.
	var activeEvent = null; // the clicked event. We'll change this to "Pending" if the user confirms the time
	var eventsRendered = new Array(); // keep track of which events were rendered so that we don't re-render them
	
	var gmtHours = new Date().getTimezoneOffset()/60;
	if (gmtHours <= 9){ gmtHours = "0"+gmtHours; }
	var timezoneAdjust = "-" + gmtHours + ":00";
	//var timezone_name = hideAlert.determine().name();


	// utility function to find out if an array contains a string. (needed for IE<9)
	if(!Array.prototype.indexOf) {
		Array.prototype.indexOf = function(needle) {
			for(var i = 0; i < this.length; i++) {
				if(this[i] === needle) {
					return i;
				}
			}
			return -1;
		};
	}
	
	
	// modal dialog for confirming a timeslot click
	$( "#dialog-modal" ).dialog({
		autoOpen: false,
		height: 320,
		width: 530,
		modal: true,						
		'buttons' : {			
			"Ok": function() {
				insertPendingEvent($( "#dialog-modal input[name=start]" ).val(),$( "#dialog-modal input[name=end]" ).val(),$( "#dialog-modal input[name=calendar_data]" ).val())
				//alert('This is Ok button');
			},
            "Cancel":function() {
				activeEvent = null;
				$( this ).dialog( "close" );
			}
		}
	});
			
				
	$( "#dialog-alert" ).dialog({
		autoOpen: false,
		height: 100,
		width: 220,
		modal: true
	});	
		
    // page is now ready, initialize the calendar...
    $('#calendar').fullCalendar({		
		ignoreTimezone: false ,	
	 	theme: true,
		weekends: false, // will hide Saturdays and Sundays
		weekMode: 'liquid',
		// height: 650,
		//contentHeight: 600,
		//aspectRatio: 1,
		//defaultView: 'month',
		defaultView: 'agendaWeek',
		allDaySlot: false,
		minTime: _minTime, /* this is set in demos_calendar_view.php */
		maxTime: _maxTime, /* this is set in demos_calendar_view.php */
		events: [ ],		
		header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek'
		},
		eventRender: function(event, element, view){},
		loading:function(isLoading,view){},
		dayClick: function(){}, 
		eventClick: function(calEvent, jsEvent, view) {
			
			var timezone_name = getTimezoneDisplay(calEvent.start);
			var timezonehours = getTimezoneOffsetDisplay(calEvent.start);

			activeEvent = calEvent;

			var roomString = "";
			for (var i = 0; i<calEvent.calendars.length; i++) { 
				if(i > 0 && i == calEvent.calendars.length-1) roomString += " and ";
				else if (i > 0)  roomString += ", ";
				roomString += calEvent.calendars[i].room_name;
			}
			
			$( "#dialog-modal p" ).html("Would you like to request this Demo time and location?<BR>Rooms: "+roomString+"<BR>" +  $.fullCalendar.formatDate(calEvent.start,"MMMM  d '('dddd')'") + "<BR>"+$.fullCalendar.formatDate(calEvent.start,"h:mm tt")+" - "+$.fullCalendar.formatDate(calEvent.end,"h:mm tt")+"<BR><BR><font style='font-size:14px;font-weight:bold;'>(Please note that times are given in "+timezone_name+") </font>");
			$( "#dialog-modal input[name=start]" ).val(calEvent.start.format("isoDateTime") + timezonehours)
			$( "#dialog-modal input[name=end]" ).val(calEvent.end.format("isoDateTime") + timezonehours)
			
			$( "#dialog-modal input[name=calendar_data]" ).val(JSON.stringify(calEvent.calendars))
			$( "#dialog-modal" ).dialog( "open" );
			// change the border color just for fun
			//$(this).css('background-color', 'red');
		},
		eventMouseover: function( event, jsEvent, view ){
			$(this).find('.fc-event-skin').css('background-color', '#e8762e');
			$(this).find('.fc-event-title').css('color', '#e8762e');
			$(this).find('.fc-event-time').css('color', '#FFFFFF');
			$(this).find('.fc-event-skin').css("opacity",1);
		},
		eventMouseout: function( event, jsEvent, view ){
			$(this).find('.fc-event-skin').css('background-color', '#5bb4cf');
			$(this).find('.fc-event-title').css('color', '#203b96');
			$(this).find('.fc-event-time').css('color', '#FFFFFF');
			$(this).find('.fc-event-skin').css("opacity",'inherit');
		},
		viewDisplay: function(view) {
			// when the view is changed
			times = new Array;
			availableTimes = new Array();
			populateWithDefaultTimeslots(view);				
		},
		eventRender: function(event, element) {
			// when an event is rendered to the screen, add it to an array. We'll compare new events to this array so they are not rendered twice.
			var stringID = event.start+event.end
			if(eventsRendered.indexOf(stringID) == -1){
				eventsRendered.push(stringID)		
			}
		}
	   
	});
	
	
	
	function populateWithDefaultTimeslots(view){
		 //alert('The new title of the view is ' + view.visStart + " - " + view.visEnd);
		//$('#calendar').fullCalendar('removeEvents');
		
		
		times = new Array();
	
		var rightnow = new Date();
		rightnow.setHours(rightnow.getHours() + 3) // add 3 hours of padding between right now and the first available timeslot
		
		// get the first date that is being displayed on the screen
		var loopDate = new Date();
		loopDate.setTime(view.visStart.valueOf());
			
		// loop through each date
		while (loopDate.valueOf() < view.visEnd.valueOf()) {
			var dayOfWeek = $.fullCalendar.formatDate(loopDate,"dddd");
			
			if(dayOfWeek == "Saturday" || dayOfWeek == "Sunday"){
				loopDate.incrementDays(1);
				continue;
			}
			
			// get the start time and end time for this day
			var startAt = new Date(loopDate.valueOf());
			startAt.setMinutes ( startAt.getMinutes() + (_minTime*60) ); // set to the time of the first timeslot of the day
			
			
			var endTime = new Date(loopDate.valueOf());
			endTime.setMinutes ( endTime.getMinutes() + (_maxTime*60) ); // set to the time of the last timeslot of the day
					
			// loop through each timeslot and push it into the "times" array
			for ($i = 0; startAt.valueOf() < endTime.valueOf(); $i ++) {  // 1800 = half hour, 86400 = one day
				
				var endAt = new Date ( startAt );
				endAt.setMinutes ( startAt.getMinutes() + _increment ); //* _increment is set in demos_calendar_view.php */
				var stringID = startAt+endAt;
				
				if(eventsRendered.indexOf(stringID) == -1){ // if this timeslot has not already been rendered!
					if(startAt.valueOf() > rightnow.valueOf()){	
						var event = new Object();       
						event.title = 'Available';
						event.start = startAt;
						event.end = endAt;
						event.allDay = false;		
						event.ignoreTimezone = true;
				
						times.push(event);
					}	
				}
				
				startAt = endAt;
				
			}
			
			loopDate.incrementDays(1); // append the date by one day.
		}
	
		calendarData = new Array();
		googleMapRoomIndex = 0;
		
		inspectGoogleMap(googleMapRoomIndex, view.visStart, view.visEnd)
		
	}
	
	
	
	function inspectGoogleMap(i,timeMin, timeMax){
		hideAlert();
		if(i < roomsArray.length){
			
			var room_name = roomsArray[i]["room_name"];
			var room_id = roomsArray[i]["room_id"];
			var calendar_id = roomsArray[i]["calendar_id"];
			var tMin = timeMin.format("isoDateTime") + timezoneAdjust;
			var tMax = timeMax.format("isoDateTime") + timezoneAdjust;	
			showAlert("Retrieving schedules");	
			//showAlert("Retrieving schedule for " + room_name);
			
			var feedURL = "https://www.googleapis.com/calendar/v3/calendars/"+calendar_id+"/events?timeMin="+tMin+"&timeMax="+tMax+"&key="+_googleAPI; /* _googleAPI isset in demos_calendar_view.php because it requires php */

			//alert(feedURL)
		// 
			
			$.ajax({
				dataType: 'jsonp',
				url: feedURL,
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Sorry, we cannot setup a call to access google calendar using this browser.");;
					//alert(errorThrown);
				},
				success: function(data) {
					//alert("success")
					//hideAlert();
					//showAlert("Schedule retrieved for " + room_name);
					var tmpArray = new Array();
					tmpArray["calendar_id"] = calendar_id;
					tmpArray["room_id"] = room_id;
					tmpArray["room_name"] = room_name;
					tmpArray["data"] = data;
					calendarData.push(tmpArray);
					inspectGoogleMap(++googleMapRoomIndex,timeMin, timeMax);					
					//setTimeout(function(){inspectGoogleMap(++googleMapRoomIndex,timeMin, timeMax);}, 300);
				}
			});
			
		} else {
			showAlert("Checking Availability");
			setTimeout(function(){checkTimeslots();}, 1);
			//checkTimeslots();		
		}
	}
	
	
	function checkTimeslots(t){
			
		var availableTimes = new Array(); 
		for (var t = 0; t<times.length; t++) { 
			var tStartTime = times[t]["start"].valueOf();
			var tEndTime = times[t]["end"].valueOf();
			var thisTimeIsAvailable = true;
			
			var calendarDataForThisTimeslot = new Array();
			
			for (var c = 0; c<calendarData.length; c++) {										// Loop through each room taken from google calendar
									
				var roomTaken = false;															// this flag will be updated to TRUE if any room is NOT available for this timeslot
				
				var tmpArray = new Object();													// create an object to hold information about this room (this google calendar)
				tmpArray["room_name"]	= 	calendarData[c].room_name
				tmpArray["calendar_id"]	= 	calendarData[c].calendar_id								
				var dataObj = calendarData[c].data;	

				var calEvents = null;															// had to do this silly loop instead of calling each key by name to get this to work in IE8 and lower
				for(myKey in dataObj){
				//for (var myKey = 0; myKey<dataObj.length; myKey++) {	
					//if(myKey == "summary")  tmpArray["room_name"] = dataObj[myKey];
					if(myKey == "etag")  	tmpArray["etag"] = dataObj[myKey];
					if(myKey == "items")  	calEvents = dataObj[myKey];
				}
				
				calendarDataForThisTimeslot.push(tmpArray);
				
				if(calEvents != null){															// if there are ANY events scheduled for the current room
					for (var i = 0; i<calEvents.length; i++) {									// Loop through each event from the current room we're looping on																		
						if(calEvents[i].start != null){
							var calStartTime = dateFromISO8601(calEvents[i].start.dateTime.toString()).valueOf();
							var calEndTime = dateFromISO8601(calEvents[i].end.dateTime.toString()).valueOf();					
							if((tStartTime < calEndTime) && (tEndTime > calStartTime)){ 							// If there is an overlap between start and end dates
								roomTaken = true 																	// One of our rooms is NOT available for this timeslot, so update this flag to TRUE				
							}
						}					
					}
				}
					
				// if the room is not available, then remove it from the list and go to the next timeslot.
				if(roomTaken == true){	
					thisTimeIsAvailable = false;	
					break;
				}
				
			}
			if(thisTimeIsAvailable == true){
				times[t]["title"] = "Available"; //calTitles.join(", ") ;// + " ("+times[t]["start"].getTimezoneOffset()+")"; // print the timezone offset for testing
				times[t]["calendars"] = calendarDataForThisTimeslot;
				//alert("Available timeslot = " + JSON.stringify(calendarDataForThisTimeslot) )
				availableTimes.push(times[t]); // found an available room, place it in the calendar and move to the next timeslot
			}
		}
		
		
		hideAlert();
		
		$('#calendar').fullCalendar( 'addEventSource', availableTimes ) 
		
		// If there are no available timeslots in this calendar period, progress to the next one.
		if($('#calendar').fullCalendar( 'clientEvents' ).length == 0){
			$('#calendar').fullCalendar( 'next' );
		}
		
	}
	
			
		
	var cancelTimeslotsAdding = false;	
	function cancelAddingTimeslots(){
		cancelTimeslotsAdding = true;
	}
	
	function showAlert(msg,showCloseIcon){
		$( "#dialog-alert" ).html(msg);
		$( "#dialog-alert" ).dialog( "open" );
		
		if(showCloseIcon == false){	
			$( ".ui-dialog-titlebar-close").css('visibility','hidden');
		} else {
			$( ".ui-dialog-titlebar-close").css('visibility','');
		}

		$( "#dialog-alert" ).parent().stop().show();
	}
	function hideAlert(){
		$("#dialog-alert").parent().fadeOut('fast', function() {
		   $( "#dialog-alert" ).dialog( "close" );
	   });
	}
	

	
	function insertPendingEvent(start,end,calendar_data,index,response_data){
		if(index == null) index = 0;
		if(response_data == null) response_data = new Array();
		$( "#dialog-modal" ).dialog('close');
		
		var arr_from_json = JSON.parse( calendar_data );
		
		// ALL DONE SAVING TO GOOGLE CALENDAR!
		if(index > arr_from_json.length - 1){
			var timezone = "Central Time (North America)"; //getTimezoneDisplay(dateFromISO8601(start));
			var startDate = $.fullCalendar.parseDate( start );
			var endDate = $.fullCalendar.parseDate( end );
			var formattedStart = $.fullCalendar.formatDate(startDate,"yyyy-MM-dd H:mm:ss");
			var formattedEnd = $.fullCalendar.formatDate(endDate,"yyyy-MM-dd H:mm:ss");	
			var displayText = $.fullCalendar.formatDate(startDate,"dddd, MMM  d") + "<br>"+$.fullCalendar.formatDate(startDate," h:mm TT")+" - "+$.fullCalendar.formatDate(endDate,"h:mm TT");
			//displayText += " (" + timezone + ")"
			
			activeEvent.title = "Pending";
			activeEvent.backgroundColor = "#CCCCCC";
			$('#calendar').fullCalendar('updateEvent', activeEvent);
					
			hideAlert();				
			parent.timeslotChosen(response_data,start,end,displayText,timezone);
			return;	
		}
		
		
		var start = start;
		var end = end;
		var calendar_id = arr_from_json[index].calendar_id
		var room_name = arr_from_json[index].room_name
		
		//alert(start + " - " + end + " - " + calendar_id);
		showAlert("Saving your timeslot for " +  room_name,false);
		var feedURL = "https://www.googleapis.com/calendar/v3/calendars/"+calendar_id+"/events?start="+start+"&end="+end+"&key=" . _googleAPI; /* _googleAPI isset in demos_calendar_view.php because it requires php */
		
		
		$.ajax({
			dataType: 'json',
			url: "/demos/ajax_insert_pending_calendar_event",
			type: "GET",
			data: {
				"calendar_id":encodeURIComponent(calendar_id),
				"start":encodeURIComponent(start),
				"end":encodeURIComponent(end),
				"label":"Pending"
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("Sorry, There was an error updating the google calendar");
				//alert(errorThrown);
			},
			success: function(data) {
				response_data.push(data);
				showAlert("Timeslot saved for " +  room_name, false);
				if(data.result == "success"){
					insertPendingEvent(start,end,calendar_data,++index,response_data)
				} else {
					alert("There was a problem updating the google calendar");
				}
			}
		});
		
	}
	
	
	
	function PadDigits(n, totalDigits) { 
		n = n.toString(); 
		var pd = ''; 
		if (totalDigits > n.length){ 
			for (var i=0; i < (totalDigits-n.length); i++) { 
			   pd += '0'; 
		   } 
	   } 
	   return pd + n.toString(); 
	} 
	
	function getTimezoneDisplay(dateObj) { //, appendShortcode = true
	
		var firstParenPos = dateObj.toString().indexOf("(")+1;
		var lastParenPos = dateObj.toString().indexOf(")");
		var timezone_name= "Central Time (North America)"; //dateObj.toString().substr(firstParenPos,lastParenPos-firstParenPos) 
		
		// if timezone name is nothing, maybe the browser formats differently, so lets try a new method
		if(timezone_name == ""){
			var lastSpace = dateObj.toString().lastIndexOf(" ");
			var timezone_name= dateObj.toString().substr(0,lastSpace) 
			var lastSpace = timezone_name.lastIndexOf(" ");
			var timezone_name = timezone_name.substr(lastSpace+1) 
			if (timezone_name == "CST") timezone_name = "Central Standard Time";
			if (timezone_name == "CDT") timezone_name = "Central Daylight Time";
		}
		//if(appendShortcode){
			if(timezone_name == "Central Daylight Time")
				timezone_name += " - CDT";
			else if (timezone_name == "Central Standard Time")
				timezone_name += " - CST";
		//}
		return timezone_name;	
		
	} 
	function getTimezoneOffsetDisplay(dateObj) { 
		var timezoneminutes = dateObj.getTimezoneOffset();
		var timezonehours = PadDigits(dateObj.getTimezoneOffset()/60,2) + ":00";
		if (timezoneminutes < 0)
			timezonehours = "+" + timezonehours;
		else
			timezonehours = "-" + timezonehours;
			
		return timezonehours;
	}
	
	
	// this function is used instead of our typical Date() function because IE8 and lower cannot parse the ISO8601 Date format provide by the google calendar API
	function dateFromISO8601(isostr) {
		 var parts = isostr.match(/\d+/g);
		 return new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[5], parts[5]);
	}

	ShowClock();
	
	

}); // END DOCUMENT READY


// utility function that adds n number of days to a date, taking timezones into account
Date.prototype.incrementDays = function(n) {		
	var thisUTC = this.getTimezoneOffset();
	this.setTime(this.getTime()+n*86400000);
	if (thisUTC!=this.getTimezoneOffset()) { 
		this.setTime(this.getTime()+(this.getTimezoneOffset()-thisUTC)*60000); 
	}
	return this;
};
	

/* _timesetter variable is set in demos_calendar_view.php (because it requires php) */
function ShowClock(){
	setTimeout("ShowClock();",1000);
	_timesetter.setTime(_timesetter.getTime()+1000);
	var hhN  = _timesetter.getHours();
	if(hhN > 12){
	   var hh = String(hhN - 12);
	   var AP = "PM";
	}else if(hhN == 12){
	   var hh = "12";
	   var AP = "PM"; 
	}else if(hhN == 0){
	   var hh = "12";
	   var AP = "AM";     
	}else{
	   var hh = String(hhN);
	   var AP = "AM";
	}
	var mm  = String(_timesetter.getMinutes());
	var ss  = String(_timesetter.getSeconds());
	TimeNow = ((hh < 10) ? " " : "") + hh + ((mm < 10) ? ":0" : ":") + mm + " " + AP ; //+ ((ss < 10) ? ":0" : ":") + ss ;
	$('.display-time .time').text(TimeNow)
}
