<div class='header big-blue-header'>
    <h1>Career Opportunities</h1>
</div>



<section class='leftCol'>

    <div class="description">
    With less than 100 employees, Vaddio is not a huge company by any means, but there is huge
opportunity to make a significant impact within the organization and make a difference. Vaddio is
growing and we would like you to be a part of our growth.

    </div>
    
    <table class="careers-list">
    	<thead>
        	<tr>
            	<th class='title'>Job Title</th>
            	<th class='locations'>Location</th>
            	<th class='buttons'></th>
            </tr>
        </thead>
        <tbody>
			<? foreach($careers as $c){ ?>
            <tr>
                <td class='title'><?=$c["title"]; ?></td>
                <td class='locations'><?=$c["location"]; ?></td>
                <td class='buttons'><a href='<?= base_url(); ?>careers/<?= $c["slug"]; ?>' class="rounded-corner-button orange-button">Learn More</a></td>
            </tr>        
            <? } ?>
        </tbody>
   	</table>
        	

</section>


<section class='rightCol'>
    
    <div class='right-col-blue-box'>
        <a href="mailto:<?=$contact_array["contact_email"];?>" class="rounded-corner-button blue-button button1">Apply Now</a><a href="<?=base_url(); ?>careers/working_at_vaddio" class="rounded-corner-button blue-button button2">Working at Vaddio</a>
        <div class='how-to-apply'>
            To apply for an open position, send your resume to  <?=$contact_array["contact_string"];?>
        </div>
    </div>
    
</section>