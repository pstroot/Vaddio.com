<div class='header big-grey-header'>
	<div class="header-rightCol">
        <form name="videoSearchForm" action="videos/search">
            <div class="finder-section finder-section-1"> 
                <div class='text-area-wrapper'>
                    <div class='text-area-wrapper-inner'>
                        <input type="text" name="searchTerm" id="supportSearchInput" value="" placeholder="Search" />
                    </div>
                </div>
                <div class='go-button-wrapper'>
                    <input type="submit" name="submit" id="supportSearchSubmit" value="GO" />
                </div>
            </div>
        </form>
    </div>
    <div class="header-leftCol">
        <h1><a href="<?= base_url() ?>videos">Videos</a></h1>
        <a href="/videos/all" class='videos-header-link all-videos-link'><div><span>See</span> All Videos</div></a>
        <a href="" class='videos-header-link view-categories-link'><div><span>Video</span> Categories</div></a>
    </div>
    
</div>

<div class='video-category-content'>
     <div class='video-categories'>
       <ul>
       <?
       foreach($categories as $c){
          echo "<li>";
          echo $c["cat_name"];
          if(count($c['children']) > 0){
               echo "<ul>";
               if(count($c['children']) > 0){
                    foreach($c['children'] as $ch){
                         if(count($ch['videos']) > 0){
                              echo "<li class='cat-link' id='cat-link-".$ch["cat_id"]."'><a href='" . base_url() . "videos/category/" . $ch["slug"] . "'>" .  $ch["cat_name"] . "</a></li>";  
                         }
                    }
               }
               echo "</ul>";
          }
          echo "</li>";
       }
       ?>
       </ul>
     </div>
</div>

<div class="videos-header-spacer"></div>





<section class='leftCol'>
    
    <? if(isset($featured_video_output)){ ?>
    <div class="featured">
        <h2>Featured Video</h2>
        <div class="featured-box">
            <?= $featured_video_output ?>
        </div>
    </div>
    <? } ?>
            
    <div clas="recent">
        <h2>Recently Added</h2>
        <ul class="video-list">
            <?
            foreach($recent as $r){
                echo "<li>" . $r["output"] . "</li>";
            }
            ?>
        </ul>
    </div>

</section>


<section class="rightCol">
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
    <? echo modules::run('Promotions'); ?>
</section>

