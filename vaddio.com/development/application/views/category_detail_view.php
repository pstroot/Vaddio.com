<?php if ($slug == "group-huddle-stations-systems"): ?>
	
<script type="text/javascript">
	
	var slider_page_position = 1;
	
	$(function() {
		
		var slider = $(".category_header_intro_slider");
		var slider_count = $(slider).find("li").length;
		
		$(slider).find("a").click(function() {
			var width = $(slider).width();
			var item_width = $(slider).find("li").first().outerWidth();
			var column_count = Math.round(width / item_width);
			var page_count = Math.ceil(slider_count / column_count);
			if ($(this).hasClass("_left")) {
				slider_page_position--;
				if (slider_page_position===0) slider_page_position = 1;
			} else {
				slider_page_position++;
				if (slider_page_position>page_count) slider_page_position = page_count;
			}
			var left = (slider_page_position-1)*width*-1;
			$(slider).find("ul").css("left",left+"px");
		});
		
		$(window).resize(function() {
			$(slider).find("ul").css("left","0");
		});
		
	});
	
</script>
	
<div class="category_header_intro">
	<h3>The Power of YOUR Apps in YOUR Meeting.</h3>
	<h1>GroupSTATION and HuddleSTATION</h1>
	<div class="category_header_intro_slider">
		<div class="category_header_intro_slider_container">
			<ul>
				<li>
					<img src="<?= base_url() ?>images/category_groupstation_room1.jpg" />
					Easily share presentations with your own tablet or laptop.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room2.jpg" />
					Easily hold a videoconference using Microsoft Lync.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room3.jpg" />
					Connect to online videos via the integrated Ethernet port.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room4.jpg" />
					Share whiteboard notes locally in the room or with partners worldwide.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room5.jpg" />
					Easily meet online with WebEx in a group room setting.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room6.jpg" />
					Jump on a conference call with integrated audio conferencing.
				</li><li>
					<img src="<?= base_url() ?>images/category_groupstation_room7.jpg" />
					Present a website or online content by just plugging in two cables.
				</li>
			</ul>
		</div>
		<a class="_left">&lt;</a>
		<a class="_right">&gt;</a>
	</div>
	<div class="category_header_intro_left">
		<?php /*<h3>It's easy as USB.</h3>*/ ?>
		<p>
			GroupSTATION and HuddleSTATION allow users to walk into any meeting room and use the application of their choice
			to collaborate in the way that best meets their needs. 
		</p>
		<p>
			Users can use their favorite collaboration tools simply by connecting personal devices to the GroupSTATION or
			HuddleSTATION control dock via a USB or HDMI connection.
		</p>
	</div>
	<div class="category_header_intro_right">
		<h3>Tune in to the right &rsquo;STATION.</h3>
		<div class="category_header_intro_right_column">
			<h4>GroupSTATION</h4>
			<p>
				GroupSTATION accomodates larger spaces for 10-20 people, featuring a camera sporting 19X optical power zoom.
			</p>
		</div>
		<div class="category_header_intro_right_column">
			<h4>HuddleSTATION</h4>
			<p>
				HuddleSTATION sees the whole picture in tighter spaces for 3-4 people. A very wide-angle lens offers greater than 82&deg; horizontal viewing. 
			</p>
		</div>
	</div>
</div>

<?php else: ?>
<div class='header big-grey-header'>
    <h1><?php echo $headline; ?></h1>
</div>
<?php endif; ?>


<section class='leftCol'> 

<?php
if(isset($slug_not_found)){?>
	 <h2>Oops!</h2>
     <h3>We could not find the category indicated by the URL supplied</h3>
     <p style="margin-top:2em;font-size:1.5em;">The category with an id of "<?=$slug;?>" does not exist.</p>
<? 
} else {
	
	// print out each product in this category
	if(count($products) > 0){
		echo "<ul class='products'>" ;
		foreach($products as $product){
			echo showProduct($product);	
		}
		echo "</ul>";
	}
	?>
	
	
	<?php // print out each sub-category in this category, along with their products ?>
	<?php if(count($sub_categories) > 0){ 
		print"<ul class='category'>";
		foreach($sub_categories as $cat){
			print "<li>";
			print "<div class='category-header'><a href='" . base_url() . "category/" . $cat["slug"] . "' name='" . $cat["slug"] . "'>" . $cat["cat_name"] . "</a></div>";
			if(count($cat["products"]) > 0){
				print "<ul class='products'>";
				foreach($cat["products"] as $product){
					echo showProduct($product);				
				}
				print "</ul>";
			}
			print "</li>";
		}
		print "</ul>";   
	} 
} // END if(isset($slug_not_found))
?>




</section>


<section class='rightCol'> 
   <?  // **************************************** PRODUCT FINDER **************************************** ?>
   
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    <? echo modules::run('Promotions'); ?>
</section>










<?php

function showProduct($productArray){
	$productArray["name"] = stripslashes($productArray["name"]);
	//$productArray["image"];
	//$productArray["product_nbr"];
	//$productArray["product_nbr"];
	//$productArray["product_number_full"];
	$systems_output = '';
	//print_r($systems);
	if(count(@$productArray["systems"]) > 0){
		$systems_output .= "<div class='systems'>
		<div class='name'>Systems featuring ".$productArray["name"] ."</div>
		<ul>";
			foreach($productArray["systems"] as $system){
				$systems_output .= "<li><a href='" . base_url() . "product/" . $system['slug'] . "'>" . $system['product_name'] . "</a></li>";
			}
			$systems_output .= "
		</ul>
		</div>";
	}
	
	$linkTo = base_url() . "product/" . $productArray["slug"];	
		
	$output  = "<li>";
	$output  .= "<div class='image'><a href='" . $linkTo . "'><img src='" . base_url() . $productArray["image"] . "'></a></div>";
	$output  .= "<div class='details'>";
	$output  .= "<div class='name'><a href='" . $linkTo . "'>" . $productArray["name"] . "</a></div>";
	$output  .= "<div class='numbers'>" . $productArray["product_number_full"] . "</div>";
	$output  .= "<div class='summary'>" . $productArray["summary"] . "</div>";
	$output  .= $systems_output ;
	$output  .= "</div></li>";	
	
	return $output;		
}

