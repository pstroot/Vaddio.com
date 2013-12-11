<div class='header big-grey-header'>
	<a href="/press" class='back-to-press'>Back <span>to Press <span>Releases</span></span></a>
    <h1>Press Releases</h1>
</div>

<section class='leftCol'>
    <? if ($name != ""){ ?>
    <h2><?= $name; ?><h2>
    <? } ?>
    
    <? if($tagline != ''){ ?>
    <h3><?= $tagline; ?></h3>
	<? } ?>
    
    
  <? if(!isset($slug_not_found)){ ?> 
    <h4><?= date("F j, Y",strtotime($theDate)); ?></h4>
    
    <div class='bodycopy'>
    <?= $description_A; ?>
    
    <?
	if(count($images) > 0){
		?>
        <div class='imageBlock'>
        <?
		foreach($images as $image){
			print "<div class='insetPhoto'>";
			print "<a href='/library?path=pr&file=" . $image["image_large"] . "' target='_blank'>
			<img src='/library?path=pr&file=" . $image["image_medium"] . "' alt='".$image["caption"]."' width='261' border='0' />
			</a>
			<p>" . stripslashes($image["caption"]) . "</p>";	
			print "</div>";
		}
		?>
		</div>
        <?
	}
    ?>
    
    <?= $description_B; ?>
    </div> <!-- END .bodycopy -->
  <? } // END if slug_not_found ?>
</section>

<section class='rightCol'>

    <? if (isset($files) && count($files) > 0){ ?>
    <div class='files rightColBlock'> 
    	<h1>Downloads</h1>  
        <ul>
        <?	
        foreach($files as $file){
            ?>
            <li>
                <a href='/library?path=pr&file=<?= $file["filepath"];?>'><?= $file["file_name"]; ?></a> 
                <?= "(" . trim($file["file_type"]) . ") " . $file["filesize"]; ?>
            </li>	
            <?
        }		
        ?>
        </ul>
    </div>
    <? } ?>
    
    
    <? if (isset($associatedProducts) && count($associatedProducts) > 0){ ?>
    <div class='associatedProducts rightColBlock'>
        <h1>Associated Products</h1>
        <ul>
        <?	
        foreach($associatedProducts as $product){ 
			?>
            <li>
                <a href='<?= base_url() . "product/" . $product->slug;?>'>
                <?= $product->name; ?>
                </a> 
            </li>	
            <?
        }		
        ?>
        </ul>
    </div>
    <? } ?>
    
   <div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    
</section>