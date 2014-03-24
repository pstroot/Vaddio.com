
	<? echo modules::run('Carousel'); ?> 

    
    <hr class="gradient" />
    
    <? echo modules::run('Product_slider'); ?> 
    

    <div class='home-blueboxes-wrapper'>
        
        <section class='home-products home-blueboxes-left'>
            	<a href="/category" class="view-all rounded-corner-button yellow-button">All Products</a>
                <h1>Products</h1>
                <? echo modules::run('FindProducts'); ?> 
        </section>
        
        <section class='home-getstarted home-blueboxes-right'>
            <h1>Get Started</h1>
            <ul>
                <li class="home-getstarted-integrators"><span></span><a href="<?= base_url() ?>get_started">Find Certified Integrators</a></li>
                <li class="home-getstarted-demos"><span></span><a href="<?= base_url() ?>demos">Schedule Product Demos</a></li>
                <li class="home-getstarted-training"><span></span><a href="<?= base_url() ?>training">Training &amp; Certification</a></li>
                <li class="home-getstarted-compare"><span></span><a href="<?= base_url() ?>compare_ptz_cameras">Compare PTZ Cameras</a></li>
            </ul>
        </section>
    
    </div><!-- END .home-blueboxes-wrapper -->
    
    <section class='home-markets'>
        <div class='home-markets-inner'>
        <h1>Markets</h1>
        <ul><? foreach($markets as $m){ ?><li>
                    <a href='markets/<?= $m['slug']; ?>'>
                        <div class="title"><?= $m['name']; ?></div>
                        <img src=' <?= base_url() . 'images/markets/' . $m['thumbnail']; ?>' />
                    </a>
                </li><? } ?></ul>
        </div>
    </section>
    
    <section class='home-videos'>
        <a href="/videos" class="view-all rounded-corner-button orange-button">All Videos</a>
        <h1>Videos</h1>
        <ul>
            <? foreach($videos as $v){ ?>
                <li>
                    <div class="home_video_container">
                        <a href='videos/<?= $v['slug']; ?>'>
                            <div class="home_video_thumb_container">
                                <div class="home_video_thumb" style="background-image:url('<?= base_url() . $v['video_thumbnail']; ?>')"><!--<img src='<?= base_url() . $v['video_thumbnail']; ?>' />--></div>
                            </div>
                            <div class="title"><?= $v['video_name']; ?></div>
                        </a>
                    </div>
                </li>
            <? } ?>
        </ul>
    </section>
    
    <hr class="gradient2" />
    
    <section class='home-events'>
    	<a href="/events" class="view-all rounded-corner-button orange-button">All Events</a>        
    	<h1>Events</h1>
    	<ul><?php
		foreach($events as $e){
			?><li>
            	<div class='event-image'>
                	<a href="<?= $e["link"]; ?>" target="_blank"><img src="<?= base_url() . "library?path=e&file=" . $e["thumbnail"]; ?>" alt="<?=$e["name"];?>" border="0"/></a>
				</div>
                <div class="description">
					<h2><a href="<?= $e["link"]; ?>" target="_blank"><?=$e["name"]; ?></a></h2>
					<?=$e["displaydate"]; ?><BR />
					<?=$e["location"]; ?><BR />
					<?=$e["details"];?>
				</div>
			</li><?
		}
		?></ul>
        <div class="clearfix"></div>
    </section>
    
    <hr class="gradient2" />
    
    <div class='home-news-promotions-container'>
    <section class='home-news before-news'>
    	<a href="/newsroom" class="view-all rounded-corner-button orange-button">All News</a>
                
        <h1>News</h1>
        <ul><?php
		foreach($news as $n){
			?><li>
            	<div class='news-image'>
                	<a href="<?= $n["link"]; ?>" target="_blank"><img src="<?= base_url() . "images/homepage_block/" . $n["image"]; ?>" alt="<?=$n["headline"];?>" border="0" <?= $n['image_parameters']; ?> /></a>
				</div>
                <div class="news-description">
                	<? if(trim($n["link"]) != ""){ ?>
                   		<h2><a href="<?= $n["link"]; ?>" target="_blank"><?=$n["headline"]; ?></a></h2>
                    <? } else { ?>
                    	<h2><?=$n["headline"]; ?></h2>
                    <? } ?>					
					<?=$n["copy"]; ?>
                    <div class="read-more-link">
                    	<a href="<?= $n["link"]; ?>" target="_blank"><?=$n["link_text"]; ?></a>
                    </div>
				</div>
			</li><?
		}
		?></ul><!-- END .news-container -->
    </section><hr class="gradient2 before-promotions" /><section class='home-promotions'>    	
    	<!--<a href="/promotions" class="view-all rounded-corner-button orange-button">All Promos</a>-->                
        <h1>Promos</h1>
    	<? echo modules::run('Promotions'); ?>
    </section>
    </div><!-- END .home-news-promotions-container -->
    
    
    
    