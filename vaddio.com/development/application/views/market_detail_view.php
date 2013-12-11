<h1 class='secondary-header'><a href="/markets">Markets</a></h1>
<div class='header big-blue-header'>
	<a href="/markets" class='back-to-markets'>Back to Markets</a>
    <h1><?= $marketDetail["name"]; ?></h1>
</div>




<section class='leftCol'>
	<? if (!isset($slug_not_found)){ ?>
	<div class='innerLeftCol'>
        <div class='images'>
            <img src=' <?= base_url() . 'images/markets/' . $marketDetail["image"]; ?>' />
        </div>
    </div><div class='innerRightCol'> <!-- END .innerLeftCol- START .innerRightCol -->
        <div class='description'>
                <?= $marketDetail["description"]; ?>       
        </div>
    </div> <!-- END .innerLeftCol -->
    
    <hr />
    
    
	<div class='innerLeftCol'>
        <div class='blue-box'>
        
        
        	<? foreach ($catalog as $c){ ?>
            <div class='product-catalog'>
                <a href='<?= base_url() . $c["path"]; ?>'><h2><span class='icon'></span>Product Catalog</h2></a>
            </div>
            <? } ?>
            
            <? if (count($press) > 0){ ?>
            <div class='press'>
                <h2><span class='icon'></span>Case Studies</h2>  
                <ul>
                    <? foreach($press as $p){ ?>
                    <li><a href='<?= base_url(); ?>press/<?= $p["slug"]; ?>'><?= $p["name"]; ?></a></li>
                    <? } ?>
                </ul>  
            </div>  
            <? } ?>
            
        </div>
    </div><div class='innerRightCol'> <!-- END .innerLeftCol- START .innerRightCol -->
    	
        <div class='blue-box2'>
        	
			<? if (count($documents) > 0){ ?>
            <div class='download-links'>
                <h2>Configuration Diagrams</h2>
                <ul>
                    <? foreach($documents as $d){ ?>
                        <li><a href='<?= $d["path"]; ?>'><?= $d["name"]; ?> (<?= $d["type"]; ?>)</a> <?=$d['size']; ?></li>
                    <? } ?>
                </ul>    
            </div>
         	<? } ?>
        
        	<? if (count($videos) > 0){ ?>
            <div class='videos'>
                <h2>Training Videos</h2>
                <ul>
                    <? foreach($videos as $v){ ?>
                        <li>
                            <div class="icon"></div>
                            <a href="<?=base_url(); ?>videos/<?= $v["slug"]; ?>">
                                <img src="<?= base_url() . $v["video_thumbnail"]; ?>">
                                <div class="title"><?= $v["video_name"]; ?></div>
                            </a>
                        </li>
                    <? } ?>
                </ul>    
            </div> 
         	<? } ?>
            
        </div>  <!-- END .blue-box2 -->
        
	</div> <!-- END .innerRightCol -->
    <? } else { // if slug not found ?>
    	<h2>Could not find the market with and ID of <?= $slug; ?>
    <? } // END if slug_not_found ?>
</section>



<section class="rightCol">

	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    
</section>
   