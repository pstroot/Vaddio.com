<script>
     $(function() {
          $("#productSearch_box").selectBoxIt({
               autoWidth: false,
               copyClasses: "container"
          }).bind({
               "create": function(ev, obj) {
                    console.log("hit");
               }
          });
     });
</script>


<div class='header big-grey-header'>
	<h1>Products</h1>
    <form name="productSearch" id="productSearch" class="productSearchPulldown" action="search.php" method="GET">
    	<select name="searchfor" onChange="selectProductFromPulldown(this)" data-placeholder="Select a Product..." id="productSearch_box" class="productSearchSelectBoxIt">
     		<option value=''>Select a Product</option>
            <? 
			foreach ($products as $product){
				echo "<option value='".base_url()."product/".$product["slug"]."'>" . $product["product_name"] . "</option>";
			}
			?>
        </select>
    </form>
   
</div>



	<!--<p>Vaddio PTZ cameras and camera control systems meet the broad spectrum of user-needs in the broadcasting, audiovisual and videoconferencing industries by combining broadcast-quality performance with the simplicity of operation and trouble-free installation and maintenance.</p>-->


<ul class='categories'><?php 
foreach( $category_list as $cat ){
	?><li class='item'>
	<a href='<?php echo base_url()."category/" . $cat["slug"]; ?>'>
    <div class='image'><img src="<?php echo $cat["image"]; ?>" alt="<?php echo $cat["cat_name"]; ?>"/></div>
	<h2><?php echo $cat["cat_name"]; ?></h2>
    </a>
	<?php echo $cat["description"]; ?>
    
    </li><li class='spacer'></li><?	
}
?></ul>

