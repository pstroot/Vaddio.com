<div class='header big-blue-header dealers-header'>
    <a href="<?= base_url() ?>dealers" class="dealers-icon"><span>Dealers</span></a>
    <h1>My Info</h1>
    <a href="<?= base_url(); ?>my_info/editPassword" class="orange-button rounded-corner-button dealers-link-button">Change Password</a>
</div>

<? 
$hidden = array('user_id' => $user->user_id);
echo form_open('','',$hidden); 
?>

<?php
/* this section is all PHP so that white spaces are eliminated. White space causes unintended wrapping */

//echo form_fieldset('Account Information',array('id' => 'account_info', 'class' => 'account_info'));
echo form_fieldset('',array('class' => 'form-no-legend'));

     echo "<div class='form-block form-block-name'>";
     echo form_label("Name:", 'user_name');
     echo form_input('user_name', set_value('user_name',$user->user_name), 'id="user_name"');
     echo form_error('user_name');
     echo "</div>";

     echo "<div class='form-block form-block-company'>";
     echo form_label("Company:", 'user_company');
     echo form_input('user_company', set_value('user_company',$user->user_company), 'id="user_company"');
     echo form_error('user_company');
     echo "</div>";

     echo "<div class='form-block form-block-address'>";
     echo form_label("Address:", 'user_address');
     echo form_input('user_address', set_value('user_address',$user->user_address), 'id="user_address"');
     echo form_error('user_address');
     echo "</div>";

     echo "<div class='form-block form-block-city'>";
     echo form_label("City:", 'user_city');
     echo form_input('user_city', set_value('user_city',$user->user_city), 'id="user_city"');
     echo form_error('user_city');
     echo "</div>";

     echo "<div class='form-block form-block-state form-block-1of2'>";
     echo form_label("State:", 'user_state');
     echo form_input('user_state', set_value('user_state',$user->user_state), 'id="user_state"');
     echo form_error('user_state');
     echo "</div>";

     echo "<div class='form-block form-block-zip form-block-2of2'>";
     echo form_label("Zip Code:", 'user_zip');
     echo form_input('user_zip', set_value('user_zip',$user->user_zip), 'id="user_zip"');
     echo form_error('user_zip');
     echo "</div>";

     echo "<div class='form-block form-block-country'>";
     echo form_label("Country:", 'user_country');
     echo form_input('user_country', set_value('user_country',$user->user_country), 'id="user_country"');
     echo form_error('user_country');
     echo "</div>";

     echo "<div class='form-block form-block-phone form-block-1of2'>";
     echo form_label("Phone:", 'user_phone');
     echo form_input('user_phone', set_value('user_phone',$user->user_phone), 'id="user_phone"');
     echo form_error('user_phone');
     echo "</div>";

     echo "<div class='form-block form-block-fax form-block-2of2'>";
     echo form_label("Fax:", 'user_fax');
     echo form_input('user_fax', set_value('user_fax',$user->user_fax), 'id="user_fax"'); 
     echo form_error('user_fax');
     echo "</div>";

     echo "<div class='form-block form-block-email'>";
     echo form_label("Email:", 'user_email');
     echo form_input('user_email', set_value('user_email',$user->user_email), 'id="user_email"');
     echo form_error('user_email');
     echo "</div>";

echo form_fieldset_close();

echo "<div class='form-block form-block-submit'>";
echo form_submit('submit','Save Changes','class="orange-button rounded-corner-button"');
echo "</div>";

echo form_close(); 
?>

