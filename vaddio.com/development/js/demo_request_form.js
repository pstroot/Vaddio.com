var timeslotChosen //This is the placeholder which sets the scope for the timeslotChosen function
	var resetForm
	
	var step1complete = false;
	var step2complete = false;
	var step3complete = false;
	var step4complete = false;
		
	$(document).ready(function() {
	
		var transitionSpeed = 500;
		var activeStep = 1;
	
		//$('.required_info').hide();
		$('.confirm-box').slideUp(0);
		//$('.form-step#step1').hide();
		$('.form-step#step2').hide();
		$('.form-step#step3').hide();
		$('.form-step#step4').hide();
		$('.demo-steps td.step1').addClass('active');
		
		$('.form-step#step1 .continue_button input').css({"opacity":".4","cursor":"inherit"});
		
		// This is the list of the rooms that the user has selected. Deactivate clicking because we're just doing a hover state with them.
		$(".rooms-selected-confirm li a").live("click",function(e){
			e.preventDefault();
		});
		
		$('.room-selection').hover(
		  function () {
			  if($(this).find('input[name=room-select]').attr('checked') == null && $(this).find('input[name=room-select]').attr('disabled') == null){
				$(this).addClass("hovered");
			  }
		  },
		  function () {
			$(this).removeClass("hovered");
		  }
		);
		
		
		$('.room-selection').click(function(e){	
			e.stopPropagation();
			var $checkbox = $(this).find('input:checkbox[name=room-select]')
			var roomID = $checkbox.val()
			$checkbox.attr("checked", !$checkbox.attr("checked"));
			selectRoom($checkbox);
		});
		
		
		/* SELECT ONE OF THE AVAILABLE ROOMS */
		$('input:checkbox[name=room-select]').click(function(e){	
			e.stopPropagation();
			var $checkbox = $(this)
			var roomID = $checkbox.val()
			selectRoom($checkbox);
		});
		
		function selectRoom($checkbox){	
			
			var $checkedBoxes = $('input:checkbox[name=room-select]:checked')
			
			if($checkedBoxes.length >= 3){
				$('input:checkbox[name=room-select]').not(':checked').closest('.room-selection').addClass("disabled");
				$('input:checkbox[name=room-select]').not(':checked').closest('.room-selection input[type=checkbox]').attr("disabled","true");
			} else if($checkedBoxes.length < 3){
				$('.room-selection').removeClass("disabled");
				$('input:checkbox[name=room-select]').not(':checked').closest('.room-selection input[type=checkbox]').removeAttr("disabled");
			}
			
			/*  change the style of the room box that this checkbox is in. */
			if($checkbox.attr('checked')){
				$checkbox.closest('.room-selection').removeClass("hovered");
				$checkbox.closest('.room-selection').addClass("active");
			} else {
				$checkbox.closest('.room-selection').addClass("hovered");
				$checkbox.closest('.room-selection').removeClass("active");
			}
			
			
			var roomIdArray 		= new Array();			
			var roomCalendarIdArray = new Array();				
			var roomNameArray 		= new Array();	
			
			
			$checkedBoxes.each(function () {
				var $this = $(this);
				roomCalendarIdArray.push( $this.nextAll(".option-calendar-id").text()	);
				roomNameArray.push( $this.nextAll(".option-room-headline").find("span.room-name").text()	);
				roomIdArray.push( $this.val() );
			});
			
			// populate hidden textfields with values we will pass when the form is submitted
			$('input[name=room_names]').val(roomNameArray.join("|"));
			$('input[name=room_ids]').val(roomIdArray.join("-"));
			$('input[name=calendar_ids]').val(roomCalendarIdArray.join("|"));
			
			// populate the list of room in the confirmation box under step on at the top of the page
			var roomString = "<ul class='rooms-selected-confirm'>";
			for(var j=0; j<roomNameArray.length; j++){
				roomString += "<li><a href='#footnote' id="+roomIdArray[j]+">" + roomNameArray[j] + "</a></li>";
			}
			roomString += "</ul>";
			$('#demo-room-select-description').html(roomString);
			
			// populate the list of room in the confirmation message
			roomString = "";
			for(var j=0; j<roomNameArray.length; j++){
				roomString += "<li>The " + roomNameArray[j] + " Room</li>";
			}
			$('#confirmation-rooms-list').html(roomString);

			
			// OPEN UP TOOLTIP
			$(".rooms-selected-confirm li a").tooltip({
				track: false, 
				delay: 1, 
				showURL: false, 
				fade: 150 ,
    			extraClass: "bubble", 
    			opacity: 1, 
				top: -38, 
    			left: 40,
				track: true,
				bodyHandler: function() {					
					populateHoverDetails($(this).attr("id"));
					return $('#room-hover-detail').html();	
				}
			});
			
		
			// show or hide the next step button
			if($checkedBoxes.length > 0){
				$('.form-step#step1 .continue_button input').css({"opacity":"1","cursor":"pointer"});
			} else {
				$('.form-step#step1 .continue_button input').css({"opacity":".4","cursor":"inherit"});
			}			
		}
	

		$('input[name=showDates]').click(function(){
			var $checkedBoxes = $('input:checkbox[name=room-select]:checked')
			if($checkedBoxes.length > 0){
				nextStep();
			}
		});

		
		$('#view-calendar-button').click(function(e){
			e.preventDefault();
			showCalendar()
		});
		
		
		function showCalendar(){			
			var rooms = $('input[name=room_ids]').val();
			var timeslotLength = 60;
	
			$.fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'maxWidth'			: '900',
				'maxHeight'			: '1000',
				'autoResize'		: true,
				'transitionIn'		: 'fade',
				'transitionOut'		: 'fade',
				'overlayColor'		: '#000000',
				'overlayOpacity'	: 0.7,
				'padding' 			: 0,			
				'type'				: 'iframe',	
				'href'				: '/demos/calendar/'+rooms+'/'+timeslotLength+'?iframe',
				'onClosed'			: function() {}
			});			
		}
		
		timeslotChosen = function(response_data,start,end,display,timezone_name){	
			//alert("TIMESLOT SAVED!")
			//alert(JSON.stringify(response_data,null,5))			
			
			$('#demo-date-value').html(display);	
			$('input[name=startTime]').val(start);
			$('input[name=endTime]').val(end);
			$('input[name=timezone]').val(timezone_name);
			//alert(response_data)
			//alert(JSON.stringify(response_data))
			$('input[name=calendar_data]').val(JSON.stringify(response_data));
			$.fancybox.close();	
			nextStep();
			
		}
		
		
		$('#choose-a-new-time-button').click(function(){
			showCalendar();
			$('.confirm-box#confirm-step2').slideUp();	
			$('.form-step#step2').slideDown();
			$('.form-step#step3').slideUp();
		});
		
		
		$('.redoButton').click(function(e){	
			e.preventDefault();
		});
		$('#revise-products-button').click(function(e){	
			step1complete = false;		
			activateStep(1);	
		});
		
		$('#choose-a-new-time-button').click(function(){	activateStep(2);	});
		$('#revise-session-details-button').click(function(){	activateStep(3);	});
		

		
		// submit the form
		$('#submit-form-button').click(function(){
			$('#demoRequestForm').submit()
		});
		$('#demoRequestForm').submit(function(e) {
			e.preventDefault();
			if(customFormValidation()){
				var data = $(this).serialize();				
				submitForm(data);
			}
		});
		
		$.ajax({
			url: "/demos/ajax_remove_pending_events"
		});
	
	 

		$('.requiredIcon').each(function(){
			$(this).css("color","#000")
			$(this).css("margin-right","5px")
			var label = $(this).prevAll("label");
			
    		$(this).prependTo(label);
		});
		
		
		
		$('.demo-steps .numbers td p').click(function(){
			if($(this).closest('td').hasClass( 'complete' )){
				activateStep($(this).text());
				
			}
		});
		
		
		function nextStep(){
			completeStep(activeStep)
		}
		
		function goToNextUnfinishedStep(){
			for(var i=1; i <= 4; i++){	
				if(window["step"+i+"complete"] !== true){
					activeStep = i;
					activateStep(activeStep);
					return;
				}
			}
		}
		
		function completeStep(step){
			window["step"+step+"complete"] = true
			
			$('.demo-steps td.step' +step).removeClass('active');
			$('.demo-steps td.step' +step).addClass('complete');
				
			// fade out the existing step fieldset
			$('.form-step#step'+step).fadeOut( transitionSpeed, function() {
				// when finished, show the confirmation of the step we completed
				$('#detailStep'+step+' .confirm-box').slideDown(transitionSpeed);
					
				goToNextUnfinishedStep()
			});
			
		}
		
		function activateStep(step){
			activeStep = step;
			// mark this step and any later steps as incomplete
			for(var i=1; i <= 4; i++){	
				if(i>=activeStep){
					window["step"+i+"complete"] = false;
				}
			}
			// make sure this step is not marked as complete (the user may be re-doing this step)
			$('.demo-steps td.step' + activeStep).removeClass('complete');
						
			// change design of numbers in progress bar after this one to incomplete
			$('.demo-steps td.step' + activeStep).nextAll('td').removeClass('complete').removeClass('active');
			
			// change design of numbers in progress bar before this one to complete
			$('.demo-steps td.step' + activeStep).prevAll('td').addClass('complete').removeClass('active');		
			
			// fade out the confirm box for this step and any future steps
			$('.demo-steps td#detailStep'+activeStep+' .confirm-box').fadeOut(transitionSpeed);
			$('.demo-steps td#detailStep'+activeStep).nextAll('td').find('.confirm-box').fadeOut(transitionSpeed);
			
			// hide any steps that are currently active after this one	 (we'll retain completed steps)
			$('.demo-steps td.step'+activeStep).addClass('active');
			
			// fade in our active step
			$('.form-step#step'+activeStep).fadeIn(transitionSpeed);
			
			// fade out any other steps our active step
			$('.form-step#step'+activeStep).nextAll('.form-step').fadeOut(transitionSpeed);
			$('.form-step#step'+activeStep).prevAll('.form-step').fadeOut(transitionSpeed);
			
		}
		
		
	
		
	
		
		function customFormValidation(){
			var errors = new Array();
			
			if($('input[name=email]').val() == ""){
				errors.push("Please enter an email address.")
			} 
			
	
			if($('input[name=startTime]').val() == ""){
				errors.push("Missing value for START DATE. Make sure you have selected a valid timeslot.")
			}
			
			
			if($('input[name=startTime]').val() == ""){
				errors.push("Missing value for START DATE. Make sure you have selected a valid timeslot.")
			}
			if($('input[name=endTime]').val() == ""){
				errors.push("Missing value for END DATE. Make sure you have selected a valid timeslot.")
			}

			if($('input[name=calendar_data]').val() == ""){
				errors.push("Missing dates from calendar. Make sure you have selected a valid timeslot.")
			}
			
			
			 if($('input[name=type-of-connection]').val() == ''){
				errors.push("You must select a type of connection")
			} 
			
			if($('input[name=type-of-connection]:checked').val() != "in multiple locations -or- using multiple platforms" &&	$('input[name=delivery_method_selected]').val() == ''){
				errors.push("You must select a delivery method")
			} 
			
			 
			if(errors.length>0){			
				$('.warning-message').html(errors.join("<BR>"));
				$('.warning-message').fadeIn(2000);
				$('html,body').animate({scrollTop: 0})
				return false;		
			} else {
				return true;
			}
		}
		
		
		
		
		function submitForm(formData){
			completeStep(3);
			$('#submitting-form').show()
			$('#form-submit-success').hide()
			$('.demo-steps td#detailStep4 h3').text('Submitting...');
			$('.warning-message').hide();
			$('#demoRequestForm input[type=submit]').css("opacity",.4);
			$('#demoRequestForm input[type=submit]').val("Sending...");
			$.ajax({
				dataType: 'json',
				url: "/demos/ajax_calendar_submit",
				type: "POST",
				data: formData,
				success: function(data) {
					$('#submitting-form').hide()
					if(data.result == "success"){
						$('#form-submit-success').show()
						window["step4complete"] = true;
						
						//$('#thankYouHTML #insert-response-message-here').html(data.responseMessage);
						var displayDate = $('#demo-date-value').html(); // get the date from the PHP submit script
						displayDate = displayDate.replace("<br>",", ");
						$('#thankyou-date').text(displayDate);
						$('.demo-steps td#detailStep4 h3').text('Confirmation');
						$('#detailStep4 .confirm-box').slideDown(transitionSpeed);
						$('.demo-steps td:last').removeClass('active').addClass('complete');
						
						// if the php script sent back any warning messages, display them on the screen.
						if(data.warnings.length > 0){
							var warningMsg = "";
							for (var i = 0; i < data.warnings.length; i++) { 
								warningMsg += "<div class='warning'>" + data.warnings[i] + "</div>";
							}
							$('.warning-message').html(warningMsg);
							$('.warning-message').fadeIn(2000);
							$('html,body').animate({scrollTop: 0})
						}
					} else if(data.result == "error"){
						$('#demoRequestForm input[type=submit]').css("opacity",1);
						var errorMsg = "";
						$.each(data.errors, function(k, v) {		
								if(placeErrorBubble($('#demoRequestForm input[name='+k+']'),v) == false){
									$('.warning-message').show();
									errorMsg += "<div class='warning'>" + v + "</div>";
								}
						});
	
						$('.warning-message').html(errorMsg);
						$('#demoRequestForm input[type=submit]').val("ERROR!");
						$('html,body').animate({scrollTop: 0});
					}
				}
			});
			
	
		}

		
		
		resetForm = function(){
				
			step1complete = false;
			step2complete = false;
			step3complete = false;
			step4complete = false;
			
			$('.form-step .confirm-box').hide();
			$('.warning-message').hide();
				
			$('#demo-room-select-description').text('');
			$('input[name=room_names]').val('');
			$('input[name=calendar_ids]').val('');
			$('input[name=room_ids]').val('');
			$('.form-step#step1 .continue_button input').css({"opacity":".4","cursor":"inherit"});
			$('input:checkbox[name=room-select]').each( function() {
				 this.checked = !this.checked;
			});
			$('.room-selection').removeClass("active");

			$('#demo-date-value').text('');
			$('input[name=startTime]').val('');
			$('input[name=endTime]').val('');
			$('input[name=calendar_data]').val('');
			$('input[name=timezone]').val('');
			

			$('input:checkbox[name=room-select]').each( function() {
				 this.checked = false;
				 this.disabled = false;
			});
			$('.room-selection').removeClass("disabled").removeClass("active");
			
			
			
			$('.demo-steps td#detailStep4 h3').text('All Done');	
			$('.form-step#step4').fadeOut(transitionSpeed,function(){
				activateStep(1);
			});
		}
		

		function populateHoverDetails(id){
			var $roomBlock = $('#room-selection-'+id);
			var theName = $roomBlock.find('.option-room-headline').text( );
			var theDesc = $roomBlock.find('.option-room-description').text( );
			var theTagline = $roomBlock.find('.option-room-tagline').html( );
			var theProducts = $roomBlock.find('.option-room-products').html( );
			var theBkgImg = $roomBlock.find('.option-room-icon').css("background-image");
			
			$('#room-hover-detail .headline').text(theName);
			$('#room-hover-detail .tagline').text(theTagline);
			//$('#room-hover-detail .description').text(theDesc);
			$('#room-hover-detail .products').html(theProducts);
			$('#room-hover-detail .icon').css("background-image", theBkgImg);
		}
			
			
  }); // END $(document).ready(function() {
	  
	