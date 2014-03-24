
<? if(!isset($slug_not_found)){ ?>    
  
<script>activeLargeImage = "<?= base_url() . $product_fullsizeimage; ?>";</script>

<? if ($isDiscontinued == 1){ ?>
	<div class='discontinued-header'>Discontinued Product</div>
<? } ?>


<? 
if (isset($parentSystemsString)){
		?>
        <div class="system-header">
        	<h3>System Featuring <?= $parentSystemsString; ?></h3>
        </div>    
<? }  ?>  
        
<div class='header big-blue-header'>
	<a href="<?= $this->config->item('support_url') . $slug; ?>" class="rounded-corner-button blue-button support-button">
		<span>Documents<BR />&amp; Support</span>
    </a>
    <h1><?php echo stripslashes($name); ?></h1>
</div>

<section class='leftCol'>
    <div class='product-numbers'><?php echo $product_number_full; ?></div>
    
	<? $container_div_class = (count($alt_images) > 0) ? "has-alt-images" : "no-alt-images";  ?>
    <div class="<?= $container_div_class; ?>">
        
        <div class="product-image">
        <a href="javascript:enlargeImage();">
        <img id="productImage" src="<?php echo base_url() . $image; ?>" alt="<?php echo $name; ?>" />
        </a></div>
        
        
        <a href="javascript:enlargeImage();" class="view-hi-res rounded-corner-button orange-button">View High Res</a>
            
        <? if (count($alt_images) > 0){  ?>
            <div class='alt-images'>
                <ul>
                    <li id='image0' onclick="javascript:swapImage('<?= base_url() . $image; ?>','<?= base_url() . $product_fullsizeimage; ?>','image0')">     
                    <img src="<?php echo base_url() . $product_thumb; ?>" alt="<?php echo $name; ?>"/>
                    </li>            
                    <?
                    for($i=0;  $i < count($alt_images); $i++){
                        echo "<li id='image".($i+1)."' onclick=\"javascript:swapImage('" . base_url() . $alt_images[$i]["image_medium"]."','". base_url() . $alt_images[$i]["image_large"]."','image".($i+1)."')\">";
                        echo "<img src='" . base_url() . $alt_images[$i]["image_medium"] . "' >";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        <? } ?>
    
        
    	<div class='description'><?php echo $description; ?></div>
    
    </div>
    
    
	<? 
	// **************************************** SPECS ****************************************
	if(count($specs) > 0){
		?>
        <div class='product-specs'>
            <h1>Product Specs</h1>
            <ul>
            <?
            foreach($specs as $s){
                echo "<li>" . $s["spec_description"] . "</li>";
            }
            ?>
            </ul>
        </div>
		<? 
	} 
	?>
    
    
    
	<? 
	// **************************************** KEY FEATURES ****************************************
	if(count($features) > 0){
		?>
        <div class='product-features'>
            <h1>Key Features</h1>
            <ul>
            <?
            foreach($features as $f){
                echo "<li>" . $f["feature_description"] . "</li>";
            }
            ?>
            </ul>
        </div>
		<? 
	} 
	?>
    
    
</section>


<section class='rightCol'> 


	<? 
	// **************************************** PRICE ****************************************
	if (isset($showPrices) && ($product_price > 0 || $product_dealer_price > 0)){ 
		?>
		<div class='product-detail product-detail-prices'>
           <h1>Price</h1>
           <dl class='prices'>    
                <? 
                if ($product_price > 0)			print "<dt>List:</dt><dd>$" . number_format($product_price, 2) . "</dd>";
                if ($product_dealer_price > 0)	print "<dt>Dealer Cost:</dt><dd>$" . number_format($product_dealer_price, 2) . "</dd>";
                ?>
           </dl>
		</div>
    	<? 
	} 
	?>
       
       
    <? 
	// *************************************** AUTHORIZED DEALERS LINK  ****************************************
	if ($show_auth_dealers == 1){ ?>
        <div class='product-detail product-detail-authdealers'>
			<a href="<?= base_url(); ?>/certified_integrators" class="rounded-corner-button blue-button">Find Certified Tracking Integrators</a>
        </div>
		<? 
	} 
	?> 


    <? 
	// **************************************** COMPARE PTZ CAMERAS ****************************************
	if(isset($showCameraComparisonLink)){ 
		?>
		<a href='<?= base_url(); ?>compare_ptz_cameras' class='product-detail-compare blue-button rounded-corner-button compare_ptz_link'>Compare PTZ Cameras</a>
    	<? 
	} 
	?>
    
    
    
	<? 
	// **************************************** SYSTEMS ****************************************
	if(count($systems) > 0){
		?>
        <div class='product-detail product-detail-systems'>
            <div class='systems-header'>
            <h1>Systems</h1>
            <h2>Featuring <?php echo stripslashes($name); ?></h2>
            </div>
            <ul>
            <?
            foreach($systems as $s){
				$linkTo = base_url() . "product/" . $s["slug"];
                ?><li>
                <div class="image"><a href='<?= $linkTo; ?>'><img src='<?= base_url() . $s["product_thumb"]; ?>' $attribute ></a></div>
                <div class="title"><a href='<?= $linkTo; ?>'><?=  stripslashes($s["product_name"]); ?></a></div>
                <div class="numbers"><?= $s["product_number_full"]; ?></div>
                <div class="summary"><?= $s["product_summary"]; ?></div>     
                </li><?
            }
            ?>
            </ul>
        </div>
		<? 
	} 
	?>




	<? if(
		count($videos) > 0 || 
		count(@$downloads) > 0 || 
		$hasAccessories || 
		count($related) > 0
		){ ?>
	
    <div class='product-detail-container'>
	<? 
	// **************************************** VIDEOS ****************************************
	if(count($videos) > 0){
		?>
        <div class='product-detail product-detail-videos videos'>
            <h1>Videos</h1>
            <ul>
            
            <?
            foreach($videos as $v){
				?>
                <li>
                    <div class="icon"></div>
                    <a href="<?= base_url() . "videos/" . $v["slug"]; ?>">
                        <div class="videos-container" style="background-image:url('<?= base_url() . $v["video_thumbnail"]; ?>')"><!--<img src="<?= base_url() . $v["video_thumbnail"]; ?>">--></div>
                        <div class="title"><?= stripslashes($v["video_name"]); ?></div>
                    </a>
                </li>
                <?
            }
            ?>
            </ul>
            
        </div>
		<? 
	} 
	?>
    
    
    
    <? 
	// **************************************** DOWNLOADS ****************************************
	// THIS HAS BEEN DEPRECIATED FOR THE SUPPORT SECTION
	if(isset($downloads) && count($downloads) > 0){ 
		?>
        <div class='product-detail product-detail-downloads'>
            <h1>Downloads</h1>
            <ul>
            <?
            foreach($downloads as $d){
                echo "<li><a href='" .base_url() . $d["path"]. "'>" . stripslashes($d["name"]) . "</a></li>";
            }
            ?>
            </ul>
        </div>
		<? 
	} 
	?>
    
    
    <?
	// **************************************** SYSTEM INCLUDES ****************************************
    if(count(@$systemIncludes) > 0){ 
		?>
        <div class='product-detail product-detail-systemincludes'>
            <h1>System Includes</h1>
            <ul>
            <?
            foreach($systemIncludes as $d){
                echo "<li><a href='" .base_url() . "product/" . $d["slug"]. "'>" . stripslashes($d["product_name"]) . "</a></li>";
            }
            ?>
            </ul>
        </div>
		<? 
    }
    ?>
    
    
    
    
    <?
	// **************************************** RELATED PRODUCTS ****************************************
    if(count($related) > 0){ 
		?>
        <div class='product-detail product-detail-related'>
            <h1>Related Products</h1>
            <ul>
                <?
                foreach($related as $r){ 
                    ?>
                    <li><a href='<?= base_url() . "product/".$r["slug"]; ?>' ><?= stripslashes($r["name"]); ?></a></li>
                    <?
                }
                ?>
            </ul>
        </div>
    	<?
    }
    ?>
    
    
    
    <?
    // **************************************** ACCESSORIES ****************************************
    if($hasAccessories){ 
        ?>
        <div class='product-detail product-detail-accessories'>
            <a href="<?= base_url() . "accessories/".$slug; ?>" class="product-detail-accessories-link rounded-corner-button"><span>Related&nbsp;</span>Accessories</a>
            <?php /*<h1>Accessories</h1>
            <a href='<?= base_url() . "accessories/".$slug; ?>' >
                <div class="image"><img src='<?= base_url() . $product_thumb; ?>' ></div>
                <?= stripslashes($name); ?> Accessories
            </a>
            */ ?>
            <div class="clearfix"></div>
        </div>
        <?
    }
    ?>
    
    
    
    </div> <!-- END .product-detail-container -->
    
    <? 
	} // END if(count($videos) > 0 || count(@$downloads) > 0 || count($accessories) > 0 || count($related) > 0) 
	?>









    
   <?  // **************************************** PRODUCT FINDER **************************************** ?>
   
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    <? echo modules::run('Promotions'); ?>
    
    
</section>



<?

// DISPLAY THIS IF THE PRODUCT IS NOT FOUND

} else { 
	?>
	<div class='header big-blue-header'>
        <h1>Product Not Found</h1>
	</div>
    <section class='leftCol'>
    	<h2>We could not find a product with an ID of "<?=$slug;?>"
    </section>
    
    <section class='rightCol'>
        <div class='findproducts-container'>
        <h1>Products</h1>
        <? echo modules::run('FindProducts'); ?>
        </div>   
        
    </section>
    
<? } ?> 
