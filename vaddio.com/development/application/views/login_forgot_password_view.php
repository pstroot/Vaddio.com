
<div class='header big-blue-header dealers-header'>
    <div class="dealers-icon"><span>Dealers</span></div>
	<h1>Forgot Password</h1>
</div>


<? if (!isset($success) || $success == false){ ?>
    
    <h2>Enter your email below and we will send you your password.</h2>
    
    <? if (isset($errorMessage)){ ?>
    <div class='errormessage'><?= $errorMessage; ?></div>
    <? } ?>

    <?php echo form_open(); ?>
    
    <?
    echo "<div class='form-block form-block-email'>";
    echo form_label("Email:", 'email');
    echo form_input('email', set_value('email'), 'id="email"');
    echo form_error('email');
    echo "</div>";
    
    // bhaAU9oHvw
    echo "<div class='form-block form-block-submit'>";
    echo form_label("", 'submit');
    echo form_submit('submit','Submit',"class='orange-button rounded-corner-button'");
    echo "</div>";
    
    echo form_close(); 
    
    ?>



<? } else { ?>
 
     
    <h2>Thank You</h2>
    
    <div class='bodycopy'>
    	<p>Your password has been reset. You will receive an email shortly with your temporary password that you can use to <a href='/login'>log in</a>. Please add <strong>registeration@vaddio.com</strong> to your spam filter.</p>
    </div>
    
    <? if (isset($errorMessage)){ ?>
    <div class='errormessage'><?= $errorMessage; ?></div>
     <? } ?>
 <? } ?>