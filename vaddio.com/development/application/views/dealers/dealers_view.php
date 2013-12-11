<div class='header big-blue-header dealers-header'>
    <a href="<?= base_url() ?>dealers" class="dealers-icon"><span>Dealers</span></a>
	<h1>Dealers</h1>
</div>


<!--<section class='leftCol'>-->
    <dl>
        <dt><a href='<?= base_url(); ?>my_info/editInfo'>My Info</a></dt>
        <dd>Edit your profile and contact information.</dd>
    </dl>
    <dl>
    <? 
    foreach ($categories as $cat){
        echo '<dt><a href="' .base_url(). 'dealers/docs/'.$cat["slug"].'">' . $cat["cat_name"] . '</a></dt>';
        echo '<dd>' . stripslashes($cat["cat_description"]) . '</dd>';
    }
    ?>
    </dl>
    <dl>
        <dt><a href='<?= base_url(); ?>dealers/job_registration'>Job Registration</a></dt>
        <dd></dd>
    </dl>
<!--</section>-->

<!--

<section class="rightCol">
	<div class='right-col-blue-box'>
        
        <div class="job-registration-link">
            <a href='<?= base_url(); ?>dealers/job_registration'  class="rounded-corner-button blue-button">Job Registration</a>
        </div>
        
        <div class="my-info-link">
            <a href='<?= base_url(); ?>my_info' class="rounded-corner-button blue-button">My Info</a>
        </div>
        
    </div>
    
    
    
</section>


-->

