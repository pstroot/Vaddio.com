<div class='header big-blue-header support-center'>
    <h1><a href='/'>Support Center</a></h1>
</div>

<h2>All Products</h2>

<p>Select a product to get support information and resources. </p>


<ul class='categories'><?php 
foreach( $category_list as $cat ){
	?><li class='item'>
	<div class='image'><img src="<?php echo $cat["image"]; ?>" alt="<?php echo $cat["cat_name"]; ?>"/></div>
	<h2><a href='<?php echo base_url()."category/" . $cat["slug"]; ?>'><?php echo $cat["cat_name"]; ?></a></h2>
	<?
	if(count($cat["products"]) > 0){
		echo "<ul>"; 
		for ($i=0; $i < count($cat["products"]); $i++){
			if($i == 4){
				echo "<li class='view-more'>View More &#9660;</li>";
				echo "</ul><ul class='more-products-list'>";
			}
			echo "<li><a href='/".$cat["products"][$i]["slug"]."'>".$cat["products"][$i]["name"]."</a></li>";	
			
		}
		echo "</ul>";
	}
	?></li><li class='spacer'></li><?	
}
?></ul>


<script>
$( document ).ready(function() {
	$(".view-more").click(function(e){
		e.preventDefault();
		$(this).slideUp();	
		$(this).parent().next('.more-products-list').slideToggle()
	});
} );
</script>

