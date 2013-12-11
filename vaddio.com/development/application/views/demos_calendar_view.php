
<script language="JavaScript">
	var _roomsArray = <?php echo json_encode($rooms); ?>;
	var _minTime = <?php echo json_encode($minTime); ?>;
	var _maxTime = <?php echo json_encode($maxTime); ?>;
	var _increment = <?php echo $increment; ?>;
	var _timesetter = new Date(<?php echo date("Y,m-1,d,H,i,s");?>); // Note: m-1 to account for javascript Date() syntax
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