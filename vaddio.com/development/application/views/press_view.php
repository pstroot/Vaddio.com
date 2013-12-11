<div class='header big-grey-header'>
    <h1>Press Releases</h1>
</div>


<div class='category-container'>
	<?
    $theYear = '';
    foreach($press as $p){
		
       if(count($p["files"]) == 0) continue; // there has to be at last one item in this category

       $start_new_year = ($theYear != $p["year"]) ? true : false;
	   
	   if($start_new_year){
		    $theYear = $p["year"];
			echo "</div>"; // END .category-container			
			echo "<div class='category-container' id='year_".$theYear."'>"; // start a new .category-container
            
            echo "<h2>" . $theYear . "</h2>";
       }
	   
       if ($theYear != $p["year"]){
            echo "<h2>" . $p["year"] . "</h2>";
       }
       ?>
        
        
        <div class="press-list-item">
        <div class='innerLeftCol'>
           
            <img src='/library?path=pr&file=<?= $p["thumbnail"]; ?>'>
        </div><div class='innerRightCol'>
            <div class='name-description'>
         		<div class="date"><?= date("F j",strtotime($p["theDate"]));?></div>
                <h3><a href='<?= base_url() . "press/" . $p['slug']; ?>'><?= $p['name']; ?></a></h3>
                <div class='description'><?= $p["tagline"]; ?></div>
            </div>
            
            <? if(count($p["files"]) > 0){ ?>
            	<ul class='files'>	
                <? 
                foreach($p["files"] as $file){
                    echo "<li>";
                    echo "<a href='/library?path=pr&file=" . $file["filepath"] . "'>" . $file["file_name"] . "</a> ";
                    //echo " (" . $file["filesize"] . " " . $file["file_type"] . ")";
                    echo "</li>";	
                }
                ?>
                </ul>
            <? } ?>
        
            </div><!-- END innerRightCol -->
        </div> <!-- END .press-list-item -->
        
        <?
	
		
	} //  END foreach($press as $p){ 
    ?>

</div><!-- END .category-container -->


   
