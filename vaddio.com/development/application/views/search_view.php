<div class='header big-grey-header'>
	<? echo modules::run('SearchForm',true); ?>
</div>


<section class='leftCol'>

	<h2>Searching for <?= $search_description; ?></h2>
    
    <? 
	if(count($products) > 0){ ?>
    <section class='product-results'>
	<div class="number-of-results"><?=count($products);?> product matches</div>    
    <ul>
		<?
        foreach($products as $p){
    		echo "<li>";
			echo "<div class='image'><img src='".base_url() . $p["product_thumb"]."'></div>";
			echo "<div class='details'>";
			if($p['isDiscontinued'] == 1){ 
           	 	echo "<div class='isDiscontinued'>Discontinued Product</div>";
			}
			echo "<div class='name'><a href='/product/" . $p["slug"]."'>". stripslashes($p["product_name"]) . "</a></div>";
			echo "<div class='numbers'>". $p["product_number_full"] . "</div>";
			//echo "<div class='summary'>". $p["summary"] . "</div>";
        	echo "</div>";
			echo "</li>"; 
        }
        ?>
    </ul>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($documents) > 0){ ?>
    <section class='document-results'>
	<div class="number-of-results"><?=count($documents);?> document matches</div>    
    <ul>
		<?
        foreach($documents as $doc){
        	echo "<li>";
    		echo "<a href='/library?path=d&file=" . $doc["path"]."'>".stripslashes($doc["name"])." " . $doc["type"] . "</a>\n	";
			//echo "<div class='description'>" . $doc["description"] . "</div>";		
			echo "</li>";
        }
        ?>
    </ul>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($categories) > 0){ ?>
    <section class='category-results'>
	<div class="number-of-results"><?=count($categories);?> category matches</div>    
    <ul>
		<?
        foreach($categories as $cat){
        	echo "<li>";
			echo "<a href='".base_url() . "category/".$cat["slug"]."'>".stripslashes($cat["cat_name"])."</a>";
			echo "<div class='description'>" . $cat["cat_description"] . "</div>";	
			echo "</li>";
        }
        ?>
    </ul>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($videos) > 0){ ?>
    <section class='video-results'>
	<div class="number-of-results"><?=count($videos);?> video matches</div>    
    <ul>
		<?
        foreach($videos as $v){
        	echo "<li>";
			echo "<a href='".base_url() . "videos/".$v["slug"]."'>".stripslashes($v["video_name"])."</a>";
			echo "<div class='description'>" . $v["video_summary"] . "</div>";	
			echo "</li>";
        }
        ?>
    </ul>
    </section>
    <? } ?>
    
    <script>
		<? foreach($searchTermArray as $s){ ?>
		$(".content section ul").highlight("<?= $s; ?>");
		<? } ?>
	</script>
	
	
	 <? if(count($products) == 0 && count($documents) && count($categories) == 0 && count($videos) == 0){  ?>
    	<h2>Enter keywords in the search field above</h2>  
    <? } ?>
    
</section>

<section class='rightCol'>
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    
    
</section>