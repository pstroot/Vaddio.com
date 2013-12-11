<div class='header big-grey-header'>
    <h1>White Papers</h1>
</div>


<?
foreach($categories as $c){
	if(count($c["whitepapers"]) == 0) continue; // there has to be at last one item in this category
	?>
	<div class='category-container'>
    <h2><?= $c["name"]; ?></h2>    
	<?
	foreach($c["whitepapers"] as $whitepaper){
		?>
        <div class="press-list-item">
            <div class='innerLeftCol'>
                <img src='/library?path=wp&file=<?= $whitepaper["thumbnail"]; ?>'>
            </div><div class='innerRightCol'>
				<div class='name-description'>
                    <h3><?= $whitepaper["name"]; ?></h3>
                    <div class='description'><?= $whitepaper["description"]; ?></div>
				</div>
				<? if(count($whitepaper["files"]) > 0){ ?>
					<ul class='files'>
						<?
                        foreach($whitepaper["files"] as $file){
                            echo "<li>";	
                            echo "<a href='/library?path=pr&file=" . $file["filepath"] . "'>" . $file["file_name"] . "</a> ";
                            //echo  $file["filesize"] . " " . $file["file_type"]; 
                            echo "</li>";	
                        }
                        ?>
					</ul>
                    <?
				}
			
			?>
       		</div> <!-- END .innerRightCol -->
        </div> <!-- END .list-item -->
    
    <?
	} // END foreach($c["press"] as $pressrelease)
	?>
	</div><!-- END .category-container -->
    <?
} // END foreach($categories as $c)



?>
