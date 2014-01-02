
<div class="home_products_scroller">
          <div class="home_products_scroller_mask">
               <ul class="home_products_scroller_images">
               	<?
				foreach($products as $product){
					echo '<li data-id="'.$product["id"].'">';
					if(trim($product["link"]) != "") echo '<a href="'.$product["link"].'">';
					echo '<img src="images/product_slider/product_images/'.$product["image"].'">';
					if(trim($product["link"]) != "") echo '</a>';
					echo '</li>';
				}
				?>
               </ul>
          </div>
          <ul class="home_products_scroller_callouts">
               <?
				foreach($products as $product){
					echo '<li data-id="'.$product["id"].'">';
					echo '<div class="title">' . $product["title"] . "</div>";
					echo stripslashes($product["summary"]);
                    echo '<span class="home_products_scroller_callout_arrow"></span>';
					echo '</li>';
				}
				?>               
          </ul>
          <div class="home_products_scroller_arrows">
               <a class="_left">&lt;</a>
               <a class="_right">&gt;</a>
          </div>
     </div>