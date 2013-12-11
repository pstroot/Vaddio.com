<div class='header big-ltblue-header'>
    
     <div class="header-leftCol">
        <h1><a href="/get_started">Certified Integrators</a></h1>
        <div class="get-started-nav">
          <a href="/premier-dealers" class='getstarted-header-link premier-dealers-link'><div>VIP EasyUSB Integrators</div></a>
          <a href="/certified-integrators" class='getstarted-header-link certified-integrators-link'><div>Certified Tracking Integrators</div></a>
         </div>
     </div>
    
</div>




<section class='leftCol'>

    <p class='summary'>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed dignissim massa, euismod
    scelerisque lacus. Aliquam a diam quis tortor pharetra mattis nec ut diam. Phasellus malesuada viverra velit
    sed congue. Pellentesque sodales massa non sapien egestas varius. Nullam hendrerit nisl quis.
    </p>
    
    
     
    
    <?
    $dealer_count = 0;
    foreach($premier_dealer_categories as $c) {
		
		if (count($c["dealers"]) > 0) {
               
               print "<h2>" . $c["cat_name"] . "</h2><ul class='premier-dealers-list'>";
		
     		foreach($c["dealers"] as $p){
     			?><li>
     				<div class='logo'>
     				<? if (trim($p["url"]) != ""){ ?><a href="<?= $p['url']; ?>" target="_blank"><? } ?>
     				<img src="/images/premier_dealers/<?= $p['logo']; ?>" alt="<?= $p["name"] ;?>" border='0'>
     				<? if (trim($p["url"]) != ""){ ?></a><? } ?>
     				</div>
     				
     				<div class='detail'>
     					<div class='name'>
     					<? if (trim($p["url"]) != ""){ ?><a href="<?= $p['url']; ?>" target="_blank"><? } ?>
     					<?= $p["name"]; ?>
     					<? if (trim($p["url"]) != ""){ ?></a><? } ?>
     					</div> 
     					   
     					<div class='address'>
     						<? if (trim($p["city"]) != "") echo ucwords($p["city"]); ?><? if (trim($p["state"]) != "") echo ", " . $p["state"]; ?>
     						<? if (trim($p["zip"]) != "") echo $p["zip"]; ?>
     					</div>
     				</div>
     			</li><?
     		}
          
               echo "</ul>";
               
               $dealer_count++;
          
          }
          
	}
     if ($dealer_count == 0) {
          echo '<p style="font-size:1.4em;font-style:italic;font-weight:bold;">Coming soon.</p>';
     }
    ?>


</section>


<section class="rightCol">
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
</section>
