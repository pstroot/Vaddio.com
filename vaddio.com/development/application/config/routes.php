<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$subdomain = array_shift(explode(".",$_SERVER['HTTP_HOST']));

if ($subdomain == 'support') {
	$route['default_controller'] = "support";
	$route['resources'] = "support/resources";
	$route['products'] = "support/products";
	$route['search/(:any)'] = "support/search/$1";
	
	$route['support/(:any)'] = "support/productSupport/$1";
	$route['categoryDetail/(:any)'] = "support/categoryDetail/$1";
	$route['tokeninput_product_search'] = "support/tokeninput_product_search";
	$route['(:any)'] = "support/productSupport/$1";
	$route['sitemap.xml'] 	 				= 'sitemap/support_sitemap';
	

} else {
	$route['default_controller'] = "home";
		
	$route['press'] 						= 'about/press';
	$route['case-studies'] 					= 'about/casestudies';
	$route['white-papers'] 					= 'about/whitepapers';
	$route['events'] 						= 'about/events';
	$route['promotions'] 					= 'about/promotions';
	$route['about-us'] 						= 'contact/about_us';
	$route['whycertify'] 					= 'training/whycertify';	
	$route['logout'] 			 			= 'login/logout';
	$route['certified-integrators']			= 'get_started/certified_integrators';
	$route['premier-dealers']				= 'get_started/premier_dealers';
	$route['category/(:any)'] 	 			= 'category/categoryDetail/$1';
	$route['accessories/(:any)'] 			= "product/accessories/$1";
	$route['product/(:any)'] 	 			= 'product/productDetail/$1';
	$route['markets/(:any)'] 	 			= 'markets/marketDetail/$1';
	$route['press/(:any)'] 		 			= 'about/pressDetail/$1';
	$route['training/installation'] 		= 'training/details/installation';
	$route['training/design'] 				= 'training/training/details/design';
	$route['videos/videoPopup/(:any)'] 	 	= 'videos/videoPopup/$1';
	$route['videos/search/(:any)'] 	 		= 'videos/search/$1';
	$route['videos/category/(:any)'] 	 	= 'videos/category/$1';
	$route['videos/all'] 	 				= 'videos/all';
	$route['videos/(:any)'] 				= 'videos/video/$1';
	$route['careers/working_at_vaddio'] 	= 'careers/working_at_vaddio';
	$route['careers/(:any)'] 				= 'careers/careerDetail/$1';
	$route['search/(:any)'] 	 			= 'search/index/$1';
	$route['intranet.html'] 	 			= 'intranet';
	$route['sitemap.xml'] 	 				= 'sitemap';
}

$route['404_override'] = 'my404';
	

/* End of file routes.php */
/* Location: ./application/config/routes.php */