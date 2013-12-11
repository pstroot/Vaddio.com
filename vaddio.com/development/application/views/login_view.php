<div class='header big-blue-header dealers-header'>
	<div class="dealers-icon"><span>Dealers</span></div>
     <h1>Login</h1>
</div>

<? if (isset($errorMessage)){ ?>
    <div class='errormessage'><?= $errorMessage; ?></div>
<? } ?>
    
<?php echo form_open(); ?>


<?php
echo "<div class='form-block form-block-username'>";
echo form_label("Username:", 'username');
echo form_input('username', set_value('username'), 'id="username"');
echo form_error('username');
echo "</div>";


echo "<div class='form-block form-block-password'>";
echo form_label("Password:", 'password');
echo form_password('password', set_value('password'), 'id="password"');
echo form_error('password');
echo "</div>";


echo "<div class='form-block form-block-submit'>";
echo form_label("", 'submit');
echo form_submit('submit',"Login","class='orange-button rounded-corner-button'");
echo "</div>";
?>


<div class="register">
	<i>Not Registered?</i> <a href='<?=base_url();?>register'>Apply Now</a>
</div>

<div class="forgot-password-prompt">
	<a href='<?=base_url();?>login/forgotPassword'>Forgot your password?</a>
</div>

<? echo form_error('login_error'); ?>
<?
echo form_close(); 
?>


