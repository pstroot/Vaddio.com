<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


/* 
LanguageLoader activates some custom classes that automatically look for the language in the subdomain name and select the proper language based on that.
This also utilizes MY_Lang.php
Also MY_Model -> selectActiveLanguage() for database queries
*/

/*
$hook['post_controller_constructor'] = array(
    'class' => 'LanguageLoader',
    'function' => 'initialize',
    'filename' => 'LanguageLoader.php',
    'filepath' => 'hooks'
);
*/

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */