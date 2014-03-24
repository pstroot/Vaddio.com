<div class='header big-blue-header header-accessories'>
    <h1>Accessories for <?php echo $name; ?></h1>
</div>

<section class='leftCol'>
    <!--<div class='product-numbers'><?php echo $product_number_full; ?></div>-->

    
  
    <?
	// **************************************** ACCESSORIES ****************************************
    if(count($accessories) > 0){ 
		?><ul class='products'><?
        foreach($accessories as $a){
		?><li>
            	<div class="image"><img src='<?= base_url() . $a["product_thumb"]; ?>' ></div><div class='details'>
                    <div class="name"><a href='<?= base_url() . "product/".$a["slug"]; ?>' ><?= $a["product_name"]; ?></a></div>
                    <div class='numbers'><?= $a["product_number_full"]; ?></div>
                    <div class="summary"><?= $a["product_summary"]; ?></div>
                </div>
            </li><?
		} 
		?></ul><?
    }
    ?>
    
    
    
    
</section>


<section class='rightCol'> 
    
   <?  // **************************************** PRODUCT FINDER **************************************** ?>
   
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    
    
</section>