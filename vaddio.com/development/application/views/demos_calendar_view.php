<script language="JavaScript">
	<?
	// use PHP to get the date/time from the server. This is more reliable than javascript, which uses the user's computer.
	$date = new DateTime();
	$timezone = new DateTimeZone("America/Chicago" ); // Make sure we're displaying Central Time Zone, regardless of the server's location. 
	$date->setTimezone( $timezone );
	// Winter = central standard time (GMT-0600)
	// Summer = central daylight time (GMT-0500)
	?>
	var _centralTimeOffset = <?php echo ($timezone->getOffset($date)/60/60); ?>;  // -6 for winter, -5 for summer	
	var _timesetter = new Date("<?php echo  $date->format('c');?>"); 
	// _timesetter format looks like this: "Mon Feb 03 2014 09:25:33 GMT-0600 (Central Standard Time)"
	var _roomsArray = <?php echo json_encode($rooms); ?>;// Object { room_id="1", calendar_id="intercomagency.com_jsj7...oup.calendar.google.com", room_name="MGM"}
	var _minTime = <?php echo json_encode($minTime); ?>; // "i.e. 8 for :8:00
	var _maxTime = <?php echo json_encode($maxTime); ?>; // i.e. 17 for 5:00
	var _increment = <?php echo $increment; ?>; 		 // i.e. 60 for 1 hour timeblocks
	var _googleAPI = "<?= $googleAPI; ?>";
	
</script>

    <h3 class="arrow">
    	<p><b>IMPORTANT NOTE:</b> All time slots are listed in <b>Central Time</b> (North America). Please adjust your timeslot selection accordingly.</p>
    </h3>
  
  	<div class="display-time">
    	<div class="line1">For reference, here is the current</div>
    	<div class="timezone">Central Time (North America):</div>
    	<div class="time"></div>
    </div>
  
  	<h1>Choose an available timeslot for your VaddioLIVE demonstration.</h1>
  
  	<div id='calendar'></div>
    
    <div id="dialog-alert" title="Loading"></div>
    
    <div id="dialog-modal" title="Confirm Date">
        <p></p>
        <input type="hidden" name="calendar_data" value="" />
        <input type="hidden" name="start" value="" />
        <input type="hidden" name="end" value="" />
    </div>
</body>
</html>