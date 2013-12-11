

<div class='header big-blue-header'>
    <h1>Request a VaddioLIVE Demo</h1>
</div>


<div class='disallow-demo'>
	<h2>We're sorry.</h2>
    <div class='summary'>
    	<p>You cannot schedule a VaddioLIVE demo using a mobile device. To schedule a demo, please return to this page on a tablet or desktop computer. Thank you. </p>
    </div>
</div>

<div class='allow-demo'>
    
    <div class="demo-steps-container">
    <table class="demo-steps">
        <tr class="numbers">
             <td id="trackStep1" class="step1"><p>1</p></td>
             <td id="trackStep2" class="step2"><p>2</p></td>
             <td id="trackStep3" class="step3"><p>3</p></td>
             <td id="trackStep4" class="step4"><p>4</p></td>
        </tr>
        <tr class="detail">
             <td id="detailStep1" class="step1">
                <div class="box">
                    <h3>Select Your<BR />Demo Rooms</h3>
                    
                    <div class="confirm-box">
                        <div class="prompt">You have selected:</div>
                        <div class="label" id="demo-room-select-description"></div>
                        <a href="#" class="redoButton" id="revise-products-button">Revise Room Choice</a>
                    </div>
                </div>
             </td>
             <td id="detailStep2" class="step2">
                <div class="box">
                    <h3>Choose a<BR />Timeslot</h3>
                    
                    <div class="confirm-box" >
                        <div class="prompt">You have scheduled:</div>                    
                        <div class="value" id="demo-date-value"></div>
                        <div id="please-note">
                            <b>PLEASE NOTE:</b> Your timeslot is listed in Central Time.
                        </div>                    
                        <a href="#" class="redoButton" id="choose-a-new-time-button">Revise Timeslot</a>                       
                    </div>
                </div>
             </td>
             <td id="detailStep3" class="step3">
                <div class="box">
                    <h3>Provide Your<BR />Contact Info</h3>
                    <div class="confirm-box">
                        <div class="prompt">Your information has been received.</div>
                    </div>
                </div>
             </td>
             <td id="detailStep4" class="step4">
                <div class="box">
                <h3>All Done</h3>
                    <div class="confirm-box">
                        <div class="prompt">You will be contacted by Vaddio with instructions for connecting to your demonstration.</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    </div>
        
    <? echo form_open('','id="demoRequestForm"'); ?>
    
    <div class="warning-message" style="display:none;"></div>
    
    <form name="demoRequestForm"  id="demoRequestForm" method="POST"> 
        <?
        echo form_hidden('room_ids','');
        echo form_hidden('room_names','');
        echo form_hidden('calendar_ids','');
        echo form_hidden('startTime','');
        echo form_hidden('endTime','');
        echo form_hidden('calendar_data','');
        echo form_hidden('timezone','');
        ?>
           
        <div style="display:<?= (isset($_GET["test"])) ? "" : "none"; ?>;">
            <b>Email to receive confirmation:</b> 
            <input type="" name="sendTo" value="<?= $sendTo; ?>" style="width:300px;"/>
        </div>
        
        
        <div class="form-step" id="step1">
            <div class="continue_button" id="continue_button_upper">
                <input type="button" name="showDates" class="theSubmitButton yellow-button rounded-corner-button" id="continue-select-room" value="Next Step &#187;"  />
            </div>
            <h1>1 Select Your Demo Rooms</h1>
            <fieldset>	
            <h2>Choose up to 3 VaddioLive demo rooms. Each of our rooms is uniquely set up in common, real-life work configurations that will help you to visualize the ways Vaddio products can make communication easy. </h2> 
            <?
            foreach($rooms as $room){
                $headline = "<span class='room-name'>" . $room["room_name"] . "</span>";
                if($room["subhead"] != "") $headline .= " - " . $room["subhead"];
                ?>
                <div class='room-selection' id='room-selection-<?= $room["room_id"]; ?>'>
                <input type='checkbox' name='room-select' value='<?= $room["room_id"]; ?>' >
                <div class='option-room-icon' 		  id='option-room-icon-<?= $room["room_id"]; ?>' style="background-image: url(/images/schedule_a_demo/rooms/<?= $room["room_icon"]; ?>);">&nbsp;</div>
                <div class='option-room-headline' 	  id='option-room-headline-<?= $room["room_id"]; ?>' ><?= $headline; ?></div>
                <div class='option-room-tagline' 	  id='option-room-tagline-<?= $room["room_id"]; ?>' ><?= $room["tagline"]; ?></div>
                <div class='option-room-description'  id='option-room-description-<?= $room["room_id"]; ?>' ><?= $room["room_description"]; ?></div>
                <div class='option-calendar-id' 	  id='option-calendar-id-<?= $room["room_id"]; ?>' ><?= $room["calendar_id"]; ?></div>       
                <ul  class='option-room-productslist' id='option-room-productslist-<?= $room["room_id"]; ?>'>
                        <?
                        foreach($room["products"] as $product){
                            print "<li>" . $product["system_name"] . "</li>";
                        }
                            
                        ?>
                    </ul>
                        
                <?
                if(count($room["products"]) > 0){ ?>
                    <div class='option-room-products' id='option-room-products-<?= $room["room_id"]; ?>'>
                    <b>Product List:</b>
                    <?
                    $productArray = array();
                    foreach($room["products"] as $product){
                        array_push($productArray,$product["system_name"]);
                    }
                    print implode(", ",$productArray);
					
					
                    ?>
                    </div>
                    <?
                }
				
				if($room["download"] != ""){
					$download_text = ($room["download_text"] == "") ? "View PDF" : $room["download_text"];
					?>
					<div class='option-room-download'>
						<a href='/images/schedule_a_demo/rooms/downloads/<?= $room["download"]; ?>' class='blue-button rounded-corner-button'><?=$download_text;?></a>
					</div>
                    <?
				}
                ?>
                        
                </div>
                <?
            } // END foreach($rooms as $room)	
            ?>
            </fieldset> 
            <div class="continue_button" id="continue_button_lower">
                <input type="button" name="showDates" class="theSubmitButton yellow-button rounded-corner-button" id="continue-select-room" value="Next Step &#187;"  />
            </div>
        </div>
    
    
    
         
        <div class="form-step" id="step2">
            <h1>Choose a timeslot</h1>
            <fieldset>
                <h2>Click the "View Schedule" button to select an available date and time that can accomodate your room requests.</h2>
                <a href="#" id="view-calendar-button" class="rounded-corner-button yellow-button">View Schedule</a>
            </fieldset>
        </div>
    
    
        
        
        <div class="form-step" id="step3">
            <h1>Provide your contact information:</h1> 
            
      
    
    
    <?php
    /* this section is all PHP so that white spaces are eliminated. White space causes unintended wrapping */
    
    echo form_fieldset('Contact Information',array('id' => 'dealer_info', 'class' => 'dealer_info'));
        
        echo "<div class='form-block form-block-company'>";
        echo form_label("Company:", 'company');
        echo form_input('company', set_value('company'), 'id="company"');
        echo form_error('company');
        echo "</div>";
        
        echo "<div class='form-block form-block-website'>";
        echo form_label("Website:", 'website');
        echo form_input('website', set_value('website'), 'id="website" placeholder="Include HTTP://"');
        echo form_error('website');
        echo "</div>";
        
        echo "<div class='form-block form-block-dealer_or_user_name'>";
        echo form_label("Dealer Name:", 'dealer_or_user_name');
        echo form_input('dealer_or_user_name', set_value('dealer_or_user_name'), 'id="dealer_or_user_name"');
        echo form_error('dealer_or_user_name');
        echo "</div>";
        
        echo "<div class='form-block form-block-contact_name'>";
        echo form_label("Contact Name:", 'contact_name');
        echo form_input('contact_name', set_value('contact_name'), 'id="contact_name"');
        echo form_error('contact_name');
        echo "</div>";
        
        echo "<div class='form-block form-block-address'>";
        echo form_label("Address:", 'contact_name');
        echo form_input('address', set_value('address'), 'id="address"');
        echo form_error('address');
        echo "</div>";
        
        echo "<div class='form-block form-block-address2'>";
        echo form_label("", 'address2');
        echo form_input('address2', set_value('address2'), 'id="address2"');
        echo form_error('address2');
        echo "</div>";
        
        echo "<div class='form-block form-block-city'>";
        echo form_label("City:", 'city');
        echo form_input('city', set_value('city'), 'id="city"');
        echo form_error('city');
        echo "</div>";
        
        echo "<div class='form-block form-block-state form-block-1of2'>";
        echo form_label("State:", 'state');
        echo form_input('state', set_value('state'), 'id="state" placeholder="2 letter state abbreviation"');
        echo form_error('state');
        echo "</div>";
        
        echo "<div class='form-block form-block-zip form-block-2of2'>";
        echo form_label("Zip:", 'zip');
        echo form_input('zip', set_value('zip'), 'id="zip"');
        echo form_error('zip');
        echo "</div>";
        
        echo "<div class='form-block form-block-phone_office'>";
        echo form_label("Phone (Office):", 'phone_office');
        echo form_input('phone_office', set_value('phone_office'), 'id="phone_office" placeholder="Please include area code"');
        echo form_error('phone_office');
        echo "</div>";
        
        echo "<div class='form-block form-block-phone_mobile'>";
        echo form_label("Phone (Mobile):", 'phone_mobile');
        echo form_input('phone_mobile', set_value('phone_mobile'), 'id="phone_mobile" placeholder="Please include area code"');
        echo form_error('phone_mobile');
        echo "</div>";
        
        echo "<div class='form-block form-block-phone_fax'>";
        echo form_label("Phone (Fax):", 'phone_fax');
        echo form_input('phone_fax', set_value('phone_fax'), 'id="phone_fax" placeholder="Please include area code"');
        echo form_error('phone_fax');
        echo "</div>";
        
        echo "<div class='form-block form-block-email required'>";
        echo form_label("Email:", 'email');
        echo form_input('email', set_value('email'), 'id="email"');
        echo form_error('email');
        echo "</div>";
        
        echo "<div class='form-block form-block-comments'>";
        echo form_label("Comments:", 'comments');
        echo form_textarea('comments', set_value('comments'), 'id="comments"');
        echo form_error('comments');
        echo "</div>";
    
    
        echo "<div class='form-block form-block-submit'>";
        echo form_submit('submit','Submit',"class='yellow-button rounded-corner-button'");
        echo "</div>";
    echo form_fieldset_close(); 
    
    ?>
    
        
    </div>
    
    
     
    <div class="form-step" id="step4">
    
        <div  id="submitting-form">
            <h1>Submitting your demo request</h1>
            <p class='bodyCopy'>Please be patient while we schedule your demo request. This may take a few moments.</p>
        </div>
        
        <div id="form-submit-success">
            <h1>Confirmation</h1>        
            <fieldset>    
                <h2>Thanks for requesting a VaddioLIVE demo!</h2>
                You've successfully submitted a request for:
                
                <div id="thankyou-date"></div>
                
                <ul class="rooms" id="confirmation-rooms-list"> </ul>
            
                <p><b>PLEASE NOTE:</b> Your timeslot is listed in Central Time (North America).</p>
                <p>A Vaddio representative will contact you to confirm your request and provide you with instructions for connecting to the demonstration.</p>
                <p>If you have questions, please contact Bernadette Yard at <a href="mailto:byard@vaddio.com">byard@vaddio.com</a> or 763-971-4466. You may want to add <a href="mailto:registration@vaddio.com">registration@vaddio.com</a> to your address book to help keep our emails from being marked as spam.</p>
            
             <a href='javascript:resetForm()'>Register for an additional demo.</a>
             
            <div id="insert-response-message-here"></div>
            </fieldset>
        </div>
    </div>
    
    
    
    
    
    <div id="room-hover-detail">
        <div class="hover-content">
            <div class='arrow'></div>
            <div class='icon'>&nbsp;</div>
            <div class='headline'></div>
            <div class='tagline'></div>
            <div class='description'></div>
            <div class='products'></div>
        </div>
    </div>
	</form>

</div> <!-- END allow-demo -->
<?
// UNCOMMENT THIS TO VIEW THE CALLOUT BUBBLE FOR DEVELOPMENT
/*
<div id="tooltip" style="position:absolute;right:2em;top:5em;"><div class="hover-content">
    <div class="arrow"></div>
    <div class="icon" style="background-image: url('http://vaddio.new/images/schedule_a_demo/rooms/mgm.png');"> </div>
    <div class="headline">MGM - Corporate Training Room</div>
    <div class="tagline">Affordable Training Room for the Enterprise</div>
    <div class="products"><b>Product List:</b>WallVIEW HD-20, MicVIEW, Hot-Shot Preset Camera Controller, StepVIEW Mat, IR Sensor, AV Bridge</div>
</div></div>
*/
?>