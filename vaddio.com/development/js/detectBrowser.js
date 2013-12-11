var isIphone  = navigator.userAgent.toLowerCase().indexOf('iphone') != -1 ;
var isIpod    = navigator.userAgent.toLowerCase().indexOf('ipod') != -1;
var isIpad    = navigator.userAgent.toLowerCase().indexOf('ipad') != -1;
var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') != -1;
var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') != -1;
var is_safari = navigator.userAgent.toLowerCase().indexOf('safari') != -1;
var is_internetExplorer = navigator.userAgent.toLowerCase().indexOf('msie') != -1;

var is_macintosh = navigator.userAgent.toLowerCase().indexOf('macintosh') != -1;
var is_windows = navigator.userAgent.toLowerCase().indexOf('windows') != -1;
	
var browser=navigator.appName;
var b_version=navigator.appVersion;
var indexOfMSIE = b_version.indexOf("MSIE");
var indexOfChrome = b_version.indexOf("Chrome");
var version2 = b_version.substr(indexOfMSIE+5);// remove the 5 characters "MSIE " also
var version=parseFloat(version2);


if (browser == "Microsoft Internet Explorer" && version >= 9){
	document.write("<link href='/includes/IE9styles.css?v=2' rel='stylesheet' type='text/css' />");
	//document.write("<link href='http://localhost/work/intercom/Vaddio/site/vaddio.com/includes/IEstyles.css' rel='stylesheet' type='text/css' />");
}
if (browser == "Microsoft Internet Explorer" && version <= 8){
	document.write("<link href='/includes/IE8styles.css?v=2' rel='stylesheet' type='text/css' />");
	//document.write("<link href='http://localhost/work/intercom/Vaddio/site/vaddio.com/includes/IE8styles.css' rel='stylesheet' type='text/css' />");
}
if (browser == "Microsoft Internet Explorer" && version <= 7){
	document.write("<link href='/includes/IE7styles.css?v=2' rel='stylesheet' type='text/css' />");
	//document.write("<link href='http://localhost/work/intercom/Vaddio/site/vaddio.com/includes/IE7styles.css' rel='stylesheet' type='text/css' />");
}
if (indexOfChrome > 0){
	document.write("<link href='/includes/chromeStyles.css?v=2' rel='stylesheet' type='text/css' />");
	//document.write("<link href='http://localhost/work/intercom/Vaddio/site/vaddio.com/includes/chromeStyles.css' rel='stylesheet' type='text/css' />");
}

