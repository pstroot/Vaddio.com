<nav class='topnav clearfix'>
    <a href="#" id="pull">Menu</a>
	<ul class='clearfix'>
    	<!--<li id=''><a href='<?= base_url(); ?>'>Home</a></li>-->
    	
        <li id="nav-products"><a href='<?= base_url(); ?>category'>Products</a>
        	<div class='submenu submenu-products'><div class='submenu-inner'> 
            	<?
				echo modules::run('FindProducts'); 
				?>
                
                <section class="markets">
               		<h1>Solutions by Market</h1>
                    <ul> 
                        <? foreach($markets as $m){ ?>
                        <li>
                            <a href='<?= base_url(); ?>markets/<?= $m['slug']; ?>'><?= $m['name']; ?></a>
                        </li>
                        <? } ?>
                    </ul>
                </section>
                
                <div class="clearfix"></div>
                
                <div class="nav-products-buttons">
                    <a class="nav-products-button" href="<?= base_url(); ?>partners">
                        <span>
                            <img src="<?= base_url(); ?>images/layout/nav_partners_icon.png">
                        </span>
                        Technology Partners
                    </a>
                    <a class="nav-products-button" href="<?= base_url(); ?>get_started">
                        <span>
                            <img src="<?= base_url(); ?>images/layout/nav_integrators_icon.png">
                        </span>
                        Certified Integrators
                    </a>
                    <a class="nav-products-button" href="<?= base_url(); ?>demos">
                        <span>
                            <img src="<?= base_url(); ?>images/layout/nav_demo_icon.png">
                        </span>
                        Schedule a Demo
                    </a>
                </div>
                
                <?php /*
                <section class='learn-more'>
                    Vaddio products work with many other equipment and services. <BR /><a href='/partners'>Learn more</a> about these technology partners.
                </section>
                */ ?>
                
            </div></div>
        </li>
        
    	<li id="nav-markets"><a href='<?= base_url(); ?>markets'>Markets</a>
        	<div class='submenu submenu-markets'><div class='submenu-inner'> 
            <ul>
					<? foreach($markets as $m){ ?>
                    <li class='subnav-market-<?= $m['slug']; ?>'>
                        <a href='<?= base_url(); ?>markets/<?= $m['slug']; ?>'><?= $m['name']; ?></a>
                    </li>
                    <? } ?>
            </ul>
        	</div></div>
        </li>
        
        <li id="nav-videos"><a href='<?= base_url(); ?>videos'>Videos</a>
            <div class='submenu submenu-videos'><div class='submenu-inner'> 
                
                <div class="submenu-videos-mask">
                    <ul>
                        <li>
                            <a href="<?= base_url() . "video/" . $featured_video->slug; ?>" class="submenu-videos-thumb-container">
                                <div class="submenu-videos-thumb" style="background-image: url('<?= base_url() . $featured_video->video_thumbnail; ?>')"><div class="icon"></div></div>
                                <?= $featured_video->video_name; ?>
                            </a>
                        </li>
						<?                        
						foreach($recent_videos as $vid){
						?>
						<li>
                            <a href="<?= base_url() . "video/" . $vid["slug"]; ?>" class="submenu-videos-thumb-container">
                                <div class="submenu-videos-thumb" style="background-image: url('<?= base_url() . $vid["video_thumbnail"]; ?>')"><div class="icon"></div></div>
                                 <?= $vid["video_name"]; ?>
                            </a>
                        </li>
						<? } ?>
                    </ul>
                </div>
                
                <div class="submenu-videos-buttons">
                    <a href="<?= base_url() ?>videos/all">
                        <span><img src="<?= base_url(); ?>images/layout/nav_videos_icon.png" /></span>
                        See All Videos
                    </a>
                </div>
                
            </div></div>
        </li>
        
        
        <?
        /*<div class='submenu submenu-markets'><div class='submenu-inner'> 
            <ul>
				<li class=''><a href='<?= base_url(); ?>videos<?= $m['slug']; ?>'>Featured and Recently Added</a></li>
				<li class=''><a href='<?= base_url(); ?>videos/all<?= $m['slug']; ?>'>All Videos</a></li>
				<li class=''><a href='<?= base_url(); ?>videos<?= $m['slug']; ?>'>Categories</a></li>
            </ul>
        	</div></div>
			*/ ?>
        </li>
        
    	<li id="nav-training"><a href='<?= base_url(); ?>training'>Training</a>  
        	<div class='submenu submenu-training'><div class='submenu-inner'> 
                
                <h2><a href='<?= base_url(); ?>training'>Camera Tracking Certification</a></h2>  
                   
                <div class='col1'>
                    <h3><a href='<?= base_url(); ?>training/register/online'>Design Certification</a></h3>
                    Perfect for system designers and sales staff, this online course enables you to design and purchase Vaddio Tracking Systems.
                    <ul>
                        <li><a href='<?= base_url(); ?>training/register/online'>Register</a></li>
                        <li><a href='<?= base_url(); ?>training/details/design'>Course Details</a></li>
                    </ul>
                </div>
                
                <div class='col2'>
                    <h3><a href='<?= base_url(); ?>training/register/onsite'>Installation Certification</a></h3>
                    This workshop at Vaddio Headquarters certifies integrators, dealers and consultants to install tracking systems.
                    <ul>
                        <li><a href='<?= base_url(); ?>training/register/onsite'>Register</a></li>
                        <li><a href='<?= base_url(); ?>training/details/installation'>Course Details</a></li>
                        <li><a href='<?= base_url(); ?>training/details/installation#lodging'>Lodging</a></li>
                    </ul>
                </div>
                
                <div class='col3'>
                    <h3><a href='<?= base_url(); ?>training/whyCertify'>Why Certify?</a></h3>
                </div>
       
            </div></div>
        </li>
        
    	<li id="nav-support"><a href='<?= $this->config->item('support_url'); ?>'>Support</a></li>
        
    	<li id="nav-about"><a href='<?= base_url(); ?>about'>About</a>
        	<div class='submenu submenu-about'><div class='submenu-inner'> 
        	<ul>            	
            	<li class='subnav-press'><a href='<?= base_url(); ?>press'>Press</a></li>
            	<li class='subnav-casestudies'><a href='<?= base_url(); ?>case-studies'>Case Studies</a></li>
            	<li class='subnav-whitepapers'><a href='<?= base_url(); ?>white-papers'>White Papers</a></li>
            	<li class='subnav-events'><a href='<?= base_url(); ?>events'>Events</a></li>
            	<li class='subnav-promotions'><a href='<?= base_url(); ?>promotions'>Promotions</a></li>
            	<li class='subnav-careers'><a href='<?= base_url(); ?>careers'>Careers</a></li>
        	</ul>
            </div></div>
        </li>
        
        
    	<li id="nav-partners"><a href='<?= base_url(); ?>partners'>Technology Partners</a></li>
        
    	
	</ul>
<hr class='nav-bottom-border' />
</nav>

