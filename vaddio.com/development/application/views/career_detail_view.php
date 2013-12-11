<div class='header big-blue-header'>
	<a href="/careers" class='back-to-careers'>Back to Careers</a>
    <h1>Job Details</h1>
</div>



<section class='rightCol'>

    <div class='right-col-blue-box'>
        <a href="mailto:<?=$contact_array["contact_email"];?>" class="rounded-corner-button blue-button button1">Apply Now</a><a href="<?=base_url(); ?>careers/working_at_vaddio" class="rounded-corner-button blue-button button2">Working at Vaddio</a>
        <div class='how-to-apply'>
            To apply for an open position, send your resume to  <?=$contact_array["contact_string"];?>
        </div>
    </div>
    
</section>


<section class='leftCol'>
    <h2 class='job-name'><?=$title; ?></h2>
    <div class="bodyCopy">
	
    
    <? if(!isset($slug_not_found)){ ?>
        <div class='job-details'>
            <dl>
                <? if(trim($location) != "")	{ ?> <dt>Location:</dt><dd><?= $location; ?></dd><? } ?>
                <? if(trim($department) != "")	{ ?> <dt>Department:</dt><dd><?= $department; ?></dd><? } ?>
                <? if(trim($posted_date) != "")	{ ?> <dt>Date Posted:</dt><dd><?= date("F j, Y",strtotime($posted_date)); ?></dd><? } ?>
            </dl>
        </div>
    
        <? if(trim(strip_tags($description) != "")){ ?>
        <div class="job-description">
            <?=$description; ?>
        </div>
        <? } ?>
        
        <? if(trim(strip_tags($footer) != "")){ ?>
        <div class="job-footer">
            <?=$footer; ?>
        </div>
        <? } ?>
    <? } // END if(!isset($slug_not_found))?>
    &nbsp;
    </div>
</section>