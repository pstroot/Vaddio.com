

$(document).ready(function() {
	
	$('.compare_ptz_link').click(function(event){
		event.preventDefault();

		$.fancybox({
			'href': '/compare_ptz_cameras/popup',
			'padding' 			: 0,		
			'type'				: 'iframe',
			'width'				: '100%',
			'autoSize'			: true,
			'autoResize'		: true,
			'autoCenter'		: true,
			'afterLoad': function (current, previous) {},
			'afterShow': function (current, previous) {}
	
		});	
		
			
	});
});
