<div class='header big-blue-header dealers-header'>
    <a href="<?= base_url() ?>dealers" class="dealers-icon"><span>Dealers</span></a>
    <h1>Change Password</h1>
    <a href="<?= base_url(); ?>my_info/editInfo" class="orange-button rounded-corner-button dealers-link-button">My Info</a>
</div>

<? 
$hidden = array('user_id' => $user["user_id"]);
echo form_open('','',$hidden); 
?>

<?php
/* this section is all PHP so that white spaces are eliminated. White space causes unintended wrapping */

echo form_fieldset('',array('class' => 'form-no-legend'));

     echo "<div class='form-block form-block-username'>";
     echo form_label("Current Password:", 'current_password');
     echo form_password('current_password', set_value('current_password'), 'id="current_password"');
     echo form_error('current_password');
     echo "</div>";

     echo "<div class='form-block form-block-password'>";
     echo form_label("Password:", 'password');
     echo form_password('password', set_value('password'), 'id="password"');
     echo form_error('password');
     echo "</div>";

     echo "<div class='form-block form-block-password2'>";
     echo form_label("Re-type Password:", 'password2'); 
     echo form_password('password2', set_value('password2'), 'id="password2"');
     echo form_error('password2');
     echo "</div>";

echo form_fieldset_close();

echo "<div class='form-block form-block-submit'>";
echo form_submit('submit','Save Changes','class="orange-button rounded-corner-button"');
echo "</div>";


echo form_close(); 
?>

