<div class='header big-blue-header dealers-header'>
    <div class="dealers-icon"><span>Dealers</span></div>
    <h1>Application</h1>
</div>

<? echo form_open(); ?>

<?php
/* this section is all PHP so that white spaces are eliminated. White space causes unintended wrapping */

echo form_fieldset('Contact Information',array('id' => 'contact_info', 'class' => 'contact_info'));

     echo "<div class='form-block form-block-name'>";
     echo form_label("Name:", 'user_name');
     echo form_input('user_name', set_value('user_name'), 'id="user_name"');
     echo form_error('user_name');
     echo "</div>";

     echo "<div class='form-block form-block-company'>";
     echo form_label("Company:", 'user_company');
     echo form_input('user_company', set_value('user_company'), 'id="user_company"');
     echo form_error('user_company');
     echo "</div>";

     echo "<div class='form-block form-block-address'>";
     echo form_label("Address:", 'user_address');
     echo form_input('user_address', set_value('user_address'), 'id="user_address"');
     echo form_error('user_address');
     echo "</div>";

     echo "<div class='form-block form-block-city'>";
     echo form_label("City:", 'user_city');
     echo form_input('user_city', set_value('user_city'), 'id="user_city"');
     echo form_error('user_city');
     echo "</div>";

     echo "<div class='form-block form-block-state form-block-1of2'>";
     echo form_label("State:", 'user_state');
     echo form_input('user_state', set_value('user_state'), 'id="user_state"');
     echo form_error('user_state');
     echo "</div>";

     echo "<div class='form-block form-block-zip form-block-2of2'>";
     echo form_label("Zip Code:", 'user_zip');
     echo form_input('user_zip', set_value('user_zip'), 'id="user_zip"');
     echo form_error('user_zip');
     echo "</div>";

     echo "<div class='form-block form-block-country form-block-1of2 form-block-orphan'>";
     echo form_label("Country:", 'user_country');
     echo form_input('user_country', set_value('user_country'), 'id="user_country"');
     echo form_error('user_country');
     echo "</div>";

     echo "<div class='form-block form-block-phone form-block-1of2'>";
     echo form_label("Phone:", 'user_phone');
     echo form_input('user_phone', set_value('user_phone'), 'id="user_phone"');
     echo form_error('user_phone');
     echo "</div>";

     echo "<div class='form-block form-block-fax form-block-2of2'>";
     echo form_label("Fax:", 'user_fax');
     echo form_input('user_fax', set_value('user_fax'), 'id="user_fax"'); 
     echo form_error('user_fax');
     echo "</div>";

     echo "<div class='form-block form-block-email form-block-1of2 form-block-orphan'>";
     echo form_label("Email:", 'user_email');
     echo form_input('user_email', set_value('user_email'), 'id="user_email"');
     echo form_error('user_email');
     echo "</div>";

     echo "<div class='form-block form-block-email2 form-block-1of2 form-block-orphan'>";
     echo form_label("Re-type Email:", 'email2');
     echo form_input('email2', set_value('email2'), 'id="email2"');
     echo form_error('email2');
     echo "</div>";

echo form_fieldset_close();

echo form_fieldset('Account Information',array('id' => 'account_info', 'class' => 'account_info'));

     echo "<div class='form-block form-block-role'>";
     echo form_label("I am a:", 'user_role'); 
     echo form_radio('user_role', 'dealer', 	 set_radio('user_role','dealer'), 'id="role-dealer"'	 ) . '  <span class="form-block-radio-label">Dealer</span>';
     echo form_radio('user_role', 'consultant', set_radio('user_role','consultant'), 'id="role-consultant"' ) . ' <span class="form-block-radio-label">Consultant</span>';
     echo form_error('user_role');
     echo "</div>";

     echo "<div class='form-block form-block-username form-block-1of2 form-block-orphan'>";
     echo form_label("Username:", 'user_username');
     echo form_input('user_username', set_value('user_username'), 'id="user_username"');
     echo form_error('user_username');
     echo "</div>";

     echo "<div class='form-block form-block-password form-block-1of2 form-block-orphan'>";
     echo form_label("Password:", 'password');
     echo form_password('password', set_value('password'), 'id="password"');
     echo form_error('password');
     echo "</div>";

     echo "<div class='form-block form-block-password2 form-block-1of2 form-block-orphan'>";
     echo form_label("Retype Password:", 'password2'); 
     echo form_password('password2', set_value('password2'), 'id="password2"');
     echo form_error('password2');
     echo "</div>";

echo form_fieldset_close();



echo form_fieldset('Submit',array('id' => 'recaptcha_response_field', 'class' => 'recaptcha_response_field'));
	 echo "<div class='form-block form-block-captcha required'>";
     echo form_label("Site Security:", 'recaptcha_response_field'); 	 
	  echo modules::run('Recaptcha'); 
     //echo recaptcha_get_html($recaptcha_public_key,NULL,TRUE);	 
	 echo form_error('recaptcha_challenge_field');
     echo form_error('recaptcha_response_field');
     echo "</div>";
echo form_fieldset_close();

echo "<div class='form-block form-block-submit'>";
echo form_submit('submit','Submit',"class='orange-button rounded-corner-button'");
echo "</div>";

echo form_close(); 
?>