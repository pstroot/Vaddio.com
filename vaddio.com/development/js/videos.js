
$( document ).ready(function() {
	
	
	
	$('form[name=videoSearchForm]').submit(function(evt){
		evt.preventDefault();			
		var value = $(this).find('input[name=searchTerm]').val();
		window.location = '/videos/search/' + escape(value);		
	});
	
	
	
	
	/* OPENING AND CLOSING THE CATEGORIES SLIDER BOX */
	$('.view-categories-link').click(function(e){
		e.preventDefault();
		$('.video-category-content').slideToggle()
	});
	
	



	/* SHOW THE VIDEO DETAILS BUBBLE ON HOVER */
	var fadeInDelay
	$.tools.tooltip.addEffect("myEffect",
		// show function
		function(done) {
			var thisTip = this.getTip();
			var pos = thisTip.parent().position().left - 80;
			var thumb = thisTip.closest('li').find('.videoThumbnail .image');
			
			if(pos < 0){
				var newLeft = thumb.position().left + thumb.width() + 10;
				thisTip.addClass('hoverRight');	
				thisTip.css('left',newLeft + 'px');
			}
			var newTop = thumb.position().top - 10;
			thisTip.css({'top':newTop + 'px','overflow':'visible'});	
			
			fadeInDelay = setTimeout(function(){
					thisTip.fadeIn(200);
					done.call();
				}, 200);
			
		},
		// hide function
		function(done) {
			clearTimeout(fadeInDelay);
			this.getTip().fadeOut(200);
			this.getTip().removeClass('hoverRight');
			done.call();			
		}
	);
	
	addVideoThumbnailActions();
	
			

	
	function addVideoThumbnailActions(){
		setUpTooltips();
		setUpFancybox();
	}
	
	
	
	
	function setUpTooltips(){			
		$('html.no-touch .videoThumbnail').each(function(i){
			offset = ($(this).next().height())+17;
			$(this).tooltip({
				'effect': 'myEffect',
				'position':'top center',
				'offset':[offset,-160],
				'delay':0,
				'predelay':0
			});
		});			
		$('html.no-touch .tooltip').css({'overflow':'inherit'});		
	}
	
	
	
	function setUpFancybox(){
		$('html.no-touch .videoThumbnail a').click(function(event) {
			var fancyboxWindowHeight = 422;
			var fancyboxContent = null;
			event.preventDefault();
	
			// stop the featured video player
			//callPlayer("youtube_<?=$featured_video_youtube_id; ?>", "pauseVideo");

			// OPEN UP A MODAL WINDOW WITH FANCYBOX
			$.fancybox({
				'href': '/videos/videoPopup/' + $(this).attr("id"),
				'padding' 			: 0,		
				'type'				: 'iframe',
				'autoSize'			: true,
				'autoResize'		: true,
				'autoCenter'		: true,
				helpers : {
					overlay : {
						css : {
							'background' : 'rgba(0, 0, 0, 0.5)'
						}
					}
				},
				'afterLoad': function (current, previous) {},
				'afterShow': function (current, previous) {}
	
			});	
			
				
		});	
		
	}
	
	
	
	
	
	function callPlayer(frame_id, func, args){
		if(!frame_id) return;
		if (browser == "Microsoft Internet Explorer" && version <= 7) return;
		
		if(frame_id.id) frame_id = frame_id.id;
		else if(typeof jQuery != "undefined" && frame_id instanceof jQuery && frame_id.length) frame_id = frame_id.get(0).id;
		if(!document.getElementById(frame_id)) return;
		args = args || [];
	
		/*Searches the document for the IFRAME with id=frame_id*/
		var all_iframes = document.getElementsByTagName("iframe");
		for(var i=0, len=all_iframes.length; i<len; i++){
			if(all_iframes[i].id == frame_id || all_iframes[i].parentNode.id == frame_id){
			   /*The index of the IFRAME element equals the index of the iframe in
				 the frames object (<frame> . */
			   window.frames[i].postMessage(JSON.stringify({
					"event": "command",
					"func": func,
					"args": args,
					"id": frame_id
				}), "*");
			}
		}
	}		

			
			
});

