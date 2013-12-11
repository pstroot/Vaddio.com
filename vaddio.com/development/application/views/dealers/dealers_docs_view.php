<script type="text/javascript">
     $(function() {
          $(".cat-name").click(function() {
               $(this).parents("li").toggleClass("_open");
          });
     });
</script>

<?php
foreach($categories as $cat){ ?>
    
    <div class='header big-blue-header dealers-header'>
        <a href="<?= base_url() ?>dealers" class="dealers-icon"><span>Dealers</span></a>
        <h1><?= stripslashes($cat['cat_name']); ?></h1>
    </div>
    
    <div class="summary">
		<?= stripslashes($cat['cat_description']); ?>
    </div>
        
        
     <?php
     if ((isset($cat["docs"]) && count($cat["docs"])) > 0 || (isset($cat["subcategories"]) && count($cat["subcategories"]) > 0)) {
          echo createListOfDocuments(@$cat["docs"]);
          ?>
          <ul class='category'>
               <?php
               if(isset($cat["subcategories"]) && count($cat["subcategories"]) > 0){
                    foreach($cat["subcategories"] as $cat){ 
                         ?>
                         <li><?= showCategory($cat); ?></li>
                         <?php
                    }
               }
               ?>
          </ul>
          <?php
     } else {
          print "<div class='no-results'>Sorry, There are currently no " . strtolower($cat['cat_name']) . " documents. Please check back for future updates.</div>"; 
     }
	?>
     
<? } ?>
        
        



<?
function showCategory($catArray){
	if(count($catArray['docs']) == 0) return; // skip this if there are no documents
	$output = "<div class='cat-name'>" . $catArray["cat_name"] . "</div>";	
	$output .= createListOfDocuments($catArray['docs']);
	return $output;
}

function createListOfDocuments($docArray){	
	if(count($docArray)==0) return;
	$output = "<ul class='docs'>";
	foreach($docArray as $doc){
		$output .= "<li class='clearfix'>" . $doc["display"] . "</li>";	
	}
	$output .= "</ul>";
	return $output;
}



