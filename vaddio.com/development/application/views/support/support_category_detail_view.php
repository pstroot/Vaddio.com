<h3><a href=''><?=  $categoryDetails->name; ?></a></h3>

<a href='' id='choose-a-different-category'>Choose a different category</a>


<?
if(count($categoryProducts) > 0){
	echo "<ul class='products'>";
	foreach($categoryProducts as $p){
		echo "<li><a href='/".$p["slug"]."'>" . $p["name"] . "</a></li>";
	}
	echo "</ul>";
}
?>


<?
	
if(count($subcategories) > 0){
	print "<ul class='categories'>";
	foreach($subcategories as $cat){
		echo "<li>";
		echo $cat["cat_name"];
		if(count($cat["products"]) > 0){
			echo "<ul class='products'>";
			foreach($cat["products"] as $p){
				echo "<li><a href='/".$p["slug"]."'>" . $p["name"] . "</a></li>";
			}
			echo "</ul>";
		}
		echo "</li>";
	}
	echo "</ul>";
}
?>



