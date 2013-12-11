<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo @$page_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?php echo base_url();?>css/styles.css" type="text/css" media="screen"/> 
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.gif" type="image/x-icon" />
    {VIEW_SPECIFIC_CSS}   
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>js/modernizr.js"></script>
    {VIEW_SPECIFIC_JAVASCRIPT}
    <!--[if IE]>      <script>document.documentElement.className += " IE";      console.log(" IE");     </script><![endif]-->
    <!--[if lt IE 9]><script src="<?= base_url(); ?>js/respond.min.js"></script>   <![endif]-->
    <!--[if lte IE 9]><script>document.documentElement.className += " lte-IE9"; console.log("lte-IE9"); </script><![endif]-->
    <!--[if lte IE 8]><script>document.documentElement.className += " lte-IE8"; console.log("lte-IE8"); </script><![endif]-->
    <script src="<?= base_url(); ?>js/retina.js"></script>

</head>
<body class="<?= @$bodyClass; ?>">


    <? echo $content; ?>   
   
	
</body>
</html>