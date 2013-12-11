<div class='header big-blue-header'>
    <h1>Thanks for Registering, <?=$firstname;?>!</h1>
</div>

<div class="leftCol">

    <h2>You have successfully registered for:</h2>
            
    <div class="classNameHeader" id="withDate" style="margin-bottom:20px;">
        <h3><?=$class_name?></h3>
        <h4><?= $displayDate; ?></h4>
    </div>
        
            
    <div class="bodycopy">
		<?php echo $success_message; ?>
    </div>
    
    <a href='<?= $more_classes_link; ?>' class="rounded-corner-button orange-button">Find More Classes</a>
    
</div>


<div class="rightCol">
	<div class='findproducts-container'>
        <h1>Products</h1>
        <? echo modules::run('FindProducts'); ?>
    </div>
</div>
    