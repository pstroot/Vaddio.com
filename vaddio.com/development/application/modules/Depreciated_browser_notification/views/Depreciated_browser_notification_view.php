<!--[if lte IE 7]> 
<script src="<?= base_url(); ?>js/ie7warning/localization/en_US.js"></script>
<script src="<?= base_url(); ?>js/ie7warning/warning.js"></script>
<script>
document.documentElement.className += " lte-IE7"; console.log("lte-IE7"); 
window.onload=function(){
	ie6Warning(function() {
		var languageMap = {};
		//specifies a JSON hash table for localization
		if(window.IE6WarningLocalizations) {
			languageMap = window.IE6WarningLocalizations;
		}
		return {
			imgPath: "/js/ie7warning/", //specifies the path to the icons of each browser
     	   localizations: languageMap
        };
	});
};
</script>
<![endif]-->