<div class='header big-grey-header'>
	<?php echo modules::run('SearchForm',true); ?>
    <h1>Search</h1>
</div>


<section class='leftCol'>

	<!--<h2>Searching for <?= $search_description; ?></h2>-->
    
    <? 
	if(count($products) > 0){ ?>
    <section class='product-results'>
    <h2>Products</h2>
    <div class="results-spacer">
    	<div class="number-of-results"><?=count($products);?> product match<?=count($products)>1?"es":""?></div>    
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
    </div>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($documents) > 0){ ?>
    <section class='document-results'>
    <h2>Documents</h2>
    <div class="results-spacer">
    	<div class="number-of-results"><?=count($documents);?> document match<?=count($documents)>1?"es":""?></div>    
        <ul>
    		<?
            foreach($documents as $doc){
            	echo "<li>";
        		echo "<a href='" . base_url() . $doc["path"]."'>".stripslashes($doc["name"])." " . $doc["type"] . "</a>\n	";
    			//echo "<div class='description'>" . $doc["description"] . "</div>";		
    			echo "</li>";
            }
            ?>
        </ul>
    </div>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($categories) > 0){ ?>
    <section class='category-results'>
    <h2>Product Categories</h2>
    <div class="results-spacer">
    	<div class="number-of-results"><?=count($categories);?> category match<?=count($categories)>1?"es":""?></div>    
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
    </div>
    </section>
    <? } ?>
    
    
    
    <? 
	if(count($videos) > 0){ ?>
    <section class='video-results'>
    <h2>Videos</h2>
    <div class="results-spacer">
    	<div class="number-of-results"><?=count($videos);?> video match<?=count($videos)>1?"es":""?></div>    
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
    </div>
    </section>
    <? } ?>
    
    <? 
    if(count($press) > 0){ ?>
    <section class='press-results'>
    <h2>Press</h2>
    <div class="results-spacer">
        <div class="number-of-results"><?=count($press);?> press match<?=count($press)>1?"es":""?></div>    
        <ul>
            <?
            foreach($press as $p){
                echo "<li>";
                echo "<a href='".base_url() . "press/".$p["slug"]."'>".stripslashes($p["name"])."</a>";
                echo "<div class='description'>" . $p["description"] . "</div>";  
                echo "</li>";
            }
            ?>
        </ul>
    </div>
    </section>
    <? } ?>
    
    <? 
    if(count($caseStudies) > 0){ ?>
    <section class='case-results'>
    <h2>Case Studies</h2>
    <div class="results-spacer">
        <div class="number-of-results"><?=count($caseStudies);?> case study match<?=count($caseStudies)>1?"es":""?></div>    
        <ul>
            <?
            foreach($caseStudies as $c){
                echo "<li>";
                echo "<a href='".base_url() . "press/".$c["slug"]."'>".stripslashes($c["name"])."</a>";
                echo "<div class='description'>" . $c["description"] . "</div>";  
                echo "</li>";
            }
            ?>
        </ul>
    </div>
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