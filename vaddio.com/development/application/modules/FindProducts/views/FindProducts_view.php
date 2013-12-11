<div class='findproducts'>
	<div class='find-products-pulldown'>
    <form name="productSearch" id="productSearch" class="productSearchPulldown" action="search.php" method="GET">
        <select name="searchfor" onChange="selectProductFromPulldown(this)" data-placeholder="Find a Product..." class="selectBoxIt_go productSearchSelectBoxIt">
		<option>Find a Product:</option>
		<? 
        foreach ($products as $product){
            echo "<option value='".base_url()."product/".$product["slug"]."'>" . stripslashes($product["product_name"]) . "</option>";
        }
        ?>
		</select>
    </form>
	</div>
        
   <nav class='find-products-by-category'>
   		<?= $category_list; ?>
   </nav>   
  
  <a class="findproducts_catalog" href="<?= base_url() ?>catalog">Catalog</a>
     
</div>


