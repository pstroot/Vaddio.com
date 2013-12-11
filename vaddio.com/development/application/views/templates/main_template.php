<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
    <title><?php echo get_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="<?php echo get_metadescription(); ?>">
    <meta name="keywords" content="<?php echo get_keywords(); ?>">
    <? if(ENVIRONMENT != 'production') { ?> <meta name="robots" content="noindex"><? } ?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="/css/styles.css" type="text/css" media="screen"/> 
    {VIEW_SPECIFIC_CSS}   
    
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/retina.css">
    
    <!--[if IE]>      <script>document.documentElement.className += " IE";      </script><![endif]-->
    <!--[if lte IE 9]><script>document.documentElement.className += " lte-IE9"; </script><![endif]-->
    <!--[if lte IE 8]><script>document.documentElement.className += " lte-IE8"; </script><![endif]-->   
    <!--[if lt IE 9]><script src="<?= base_url(); ?>js/css3-mediaqueries.js"></script><![endif]-->
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>js/modernizr.js"></script>
    <script src="<?= base_url(); ?>js/global.js"></script>
    {VIEW_SPECIFIC_JAVASCRIPT}   
	<script src="<?= base_url(); ?>js/retina.js"></script>
	<script src="<?= base_url(); ?>js/google_analytics.js"></script>  
   
</head>
<body class="<?= @$bodyClass; ?><?= $this->authorization->is_logged_in() ? ' logged_in' : '' ?>">

<? echo modules::run('Partner_nav'); ?>

<div id="container">
    <div class="header_container">
        <div class="header_block"></div>
        <header>
            <a  href="<?php echo base_url();?>"><h1 class='logo'>Vaddio.com</h1></a>
          
           
            <? echo modules::run('Top_nav'); ?>
            
           <div class="top-right-corner-links">
           
               
               <ul class="utility-links">
                    <li class='get-started'><a href='<?= base_url(); ?>get_started'>Get Started</a>
                        <ul class='subnav'>
                            <li class=''><a href='<?= base_url(); ?>premier-dealers'>Premier Dealers</a></li>
                            <li class=''><a href='<?= base_url(); ?>certified-integrators'>Certified Tracking Integrators</a></li>
                            <li class=''><a href='<?= base_url(); ?>demos'>Schedule a Demo</a></li>
                        </ul>                
                    </li>
                    <li class='catalog'><a href='<?= base_url(); ?>catalog'>Catalog</a></li>
                    <li class='contact'><a href='<?= base_url(); ?>contact'>Contact</a></li>
                    <li class='partners'><a href='<?= base_url(); ?>partners'><span>Technology </span>Partners</a></li>
                    <? if($this->authorization->is_logged_in()){ ?>
                        <li class='logout'><a href='<?= base_url(); ?>login/logout'>Log Out</a></li>
                    <? } else { ?>
                        <li class='login'><a href='<?= base_url(); ?>login'>Login</a></li>
                    <? } ?>
                </ul>
                
                <div class="socialmedia-links"><ul><li class='twitter image-link'><a href='http://twitter.com/Vaddio'>Twitter</a></li><li class='linkedin image-link'><a href='http://www.linkedin.com/companies/vaddio?trk=co_search_results&goback=.cps_1262030040048_1'>Linked In</a></li><li class='facebook image-link'><a href='http://www.facebook.com/vaddio'>Facebook</a></li><li class='youtube image-link'><a href='https://www.youtube.com/user/Vaddio2?feature=watch'>YouTube</a></li><li class='email image-link'><a href='/contact'>Email</a></li></ul></div><div class="search">
                    <a href='/search'>Search</a>
                    <? echo modules::run('SearchForm',false); ?>
                </div>
                
            </div>
           
        </header>
    </div>

	<div class='content'>
    <? echo $content; ?>   
    </div>
    
	<div style="clear:both;"></div>
    
    <? echo modules::run('Footer'); ?>
    
	

</div> <!-- END #container -->



</body>

<? echo modules::run('Depreciated_browser_notification'); ?>

</html>