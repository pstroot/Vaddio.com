<div class='header big-blue-header'>
    <h1>Camera Tracking Certification</h1>
</div>

<ul class='tabs'>
    <li class="online"><a href='<?= base_url(); ?>/training/register/online'>Design</a></li>
    <li class="onsite"><a href='<?= base_url(); ?>/training/register/onsite'>Installation</a></li>
</ul>
<hr class="tabs-bottom-border" />

<h2><?php echo $headline; ?></h2>

<div class="leftCol">

<div class="innerLeftCol">


<?php echo form_open(); ?>

<?php

echo form_fieldset('Register for a Class',array('id' => 'training_class_register', 'class' => 'training_class_register'));

     echo "<div class='form-block form-block-class'>";
     //echo form_label("Register for a Class:", 'session_id');
     echo form_error('session_id');
     echo "<div class='scrollable'>";
     foreach($classes as $class){
     	echo "<div class='class-block'>";
     	echo form_radio('session_id', $class["session_id"],  set_radio('session_id', $class["session_id"]), 'id="class"') ;
     	echo "<div class='radio-description'>";
     	echo $class["displayDate"];
     	echo "<div class='message'>" . $class["closedReason"] . "</div>";
     	echo "</div>";
     	echo "</div>";
     }
     echo "</div>";
     echo "</div>";

     echo "<div class='form-block form-block-company required'>";
     echo form_label("Company Name:", 'name');
     echo form_input('company', set_value('company'), 'id="company"');
     echo form_error('company');
     echo "</div>";

     echo "<div class='form-block form-block-dealer_nbr required'>";
     echo form_label("Dealer Number:", 'dealer_nbr');
     echo form_input('dealer_nbr', set_value('dealer_nbr'), 'id="dealer_nbr"');
     echo form_error('dealer_nbr');
     echo "</div>";

     echo "<div class='form-block form-block-company_website required'>";
     echo form_label("Company Website:", 'company_website');
     echo form_input('company_website', set_value('company_website'), 'id="company_website"');
     echo form_error('company_website');
     echo "</div>";

     echo "<div class='form-block form-block-firstname required'>";
     echo form_label("Attendee First Name:", 'firstname');
     echo form_input('firstname', set_value('firstname'), 'id="firstname"');
     echo form_error('firstname');
     echo "</div>";

     echo "<div class='form-block form-block-lastname required'>";
     echo form_label("Attendee Last Name:", 'lastname');
     echo form_input('lastname', set_value('lastname'), 'id="lastname"');
     echo form_error('lastname');
     echo "</div>";

     echo "<div class='form-block form-block-address required'>";
     echo form_label("Address:", 'address');
     echo form_input('address', set_value('address'), 'id="address"');
     /*
     echo form_label("", 'address2');
     echo form_input('address2', set_value('address2'), 'id="address2"');
     echo form_error('address2');
     */
     echo form_error('address');
     echo "</div>";



     echo "<div class='form-block form-block-city required'>";
     echo form_label("City:", 'city');
     echo form_input('city', set_value('city'), 'id="city"');
     echo form_error('city');
     echo "</div>";

     echo "<div class='form-block form-block-state required'>";
     echo form_label("State:", 'state');
     echo form_input('state', set_value('state'), 'id="state"');
     echo form_error('state');
     echo "</div>";

     echo "<div class='form-block form-block-zip required'>";
     echo form_label("Zip:", 'zip');
     echo form_input('zip', set_value('zip'), 'id="zip"');
     echo form_error('zip');
     echo "</div>";

     echo "<div class='form-block form-block-country'>";
     echo form_label("Country:", 'country');
     echo form_input('country', set_value('country'), 'id="country"');
     echo form_error('country');
     echo "</div>";

     echo "<div class='form-block form-block-phone required'>";
     echo form_label("Phone:", 'phone');
     echo form_input('phone', set_value('phone'), 'id="phone"');
     echo form_error('phone');
     echo "</div>";

     echo "<div class='form-block form-block-fax'>";
     echo form_label("Fax:", 'fax');
     echo form_input('fax', set_value('fax'), 'id="fax"'); 
     echo form_error('fax');
     echo "</div>";

     echo "<div class='form-block form-block-email required'>";
     echo form_label("Email:", 'email');
     echo form_input('email', set_value('email'), 'id="email"');
     echo form_error('email');
     echo "</div>";


		 echo "<div class='form-block form-block-captcha required'>";
		 echo form_label("Site Security:", 'recaptcha_response_field'); 
		 
	  	echo modules::run('Recaptcha'); 
	  	//echo recaptcha_get_html($recaptcha_public_key,NULL,true);
		 echo form_error('recaptcha_challenge_field');
		 echo form_error('recaptcha_response_field');
		 echo "</div>";



echo form_fieldset_close();

echo "<div class='form-block form-block-submit'>";
echo form_label("", 'submit');
echo form_submit('submit','Register','class="rounded-corner-button orange-button"');
echo "</div>";

echo form_close(); 
?>
	</div><div class='innerRightCol'><!-- END inner left column, start inner right column -->
    	
        
        <div class='info-block info-block-about'>
        	<h2>About this course</h2>
            <div class='info-block-content'>
            	<?= $class_description; ?>
            </div>
        </div>
        
        <div class='info-block info-block-moreinfo'>
            <h2>More Info</h2>
            <div class='info-block-content'>
                <ul>
                	<? 
					//print "<pre>";print_r($moreinfo);print"</pre>";
					foreach($moreinfo as $key => $val){
						if(count($val) > 0){
							print "<li>$key";							
							print "<ul>";
							foreach($val as $doc){
								print "<li>";
								print "<a href='" . $doc["path"] . "'>";
								print $doc["description"];
								if(isset($doc["type"]) && $doc["type"] != "anchor") print " (".$doc["type"].")";
								print "</a>";
								print "</li>";
							}							
							print "</ul>";
							print "</li>";
						} 
					} 
					?>
                   <!-- <li>Warranty and Return Policy (PDF)</li> -->
                </ul>
                
                <b><?= $credits_label; ?></b><BR />
                <?= $credits_text; ?>
                <img src='<?= base_url(); ?>images/infocomm_logo.gif' alt='infoComm International'  />
            </div>
        </div>
        
    </div>
</div> <!-- END main left column -->




<div class="rightCol">
	<div class='findproducts-container'>
        <h1>Products</h1>
        <? echo modules::run('FindProducts'); ?>
    </div>
</div>
