$( document ).ready(function(e) {
	
	//$('.lte-IE8 .home-product-display .pointer').hide();

	 
	// make draggable (TO DO: allow for touch screens only! )
	var total_width_loaded = 0;

	var $drag_container = $('.touch .scroll-container ul');
	//var $drag_container = $('.touch .scroll-container ul');
	$drag_container.draggable({axis:"x"});
	$drag_container.mousedown(function(){
		startDragging()
	});
	
	
	
	var counter = 1;
	$('.home-product-display li').each(function(){
		
		var $this = $(this);
		var $callout = $this.find('.callout');
		var $pointer = $this.find('.pointer');

		// if the image is not found then hide it
		$this.find('img').error(function(){
			//console.log("problem finding an image")
		  	$(this).hide();
		});
			
		// wait for the image to load, then position the callout bubble based on the image size and position.
		
		$this.find('img').each(function() {
			tmpImg = new Image();
			tmpImg.onload = function() { // this allows the "load" event to fire even if the image was cached. tmpImage is never added to the DOM, so it does not display.
				
				total_width_loaded += $this.width();
				//console.log(counter + ") LOADED: " + $this.width() + " TOTAL: " + total_width_loaded);
				
				counter++;
				
				var pointerPosition = ($callout.width()*.5) - ($pointer.width()*.5);
				$pointer.css('margin-left',pointerPosition)
				
				var bubbleTopPosition = ($callout.outerHeight() + ($pointer.height()/2) )* -1 
				$callout.css('margin-top',bubbleTopPosition + "px")
				
				var bubbleLeftPosition = ($callout.outerWidth() - $this.width())*-.5
				//console.log("-> " + $this.width())
				$callout.css('margin-left',bubbleLeftPosition + "px")
			};
			tmpImg.src = $(this).attr('src') ;
		
		});
		
		
		
	});
	
	
	// show and hide the callout bubble when the image is rolled over
	$('.no-touch .home-product-display li').hover(function(){
		$(this).find('.callout').hide();	
		$(this).find('.callout').stop().fadeIn(300);	
	},function(){
		$(this).find('.callout').stop().fadeOut(200);	
	});
	
	
	
    var scrolling = false;
	
	//$('.touch .home-product-display .arrow').hide(); // hide the scroll arrows if we're on a touch-screen
	
	

	
	$('.home-product-display .right-arrow').bind('mousedown touchstart', function(e){
	//$('.no-touch .home-product-display .right-arrow').mousedown(function(e){
    	scrolling = true;
    	startScrolling("-=10px");
    });
	
	$('.home-product-display .left-arrow').bind('mousedown touchstart', function(e){
	//$('.no-touch .home-product-display .left-arrow').mousedown(function(e){
    	scrolling = true;
    	startScrolling("+=10px");
    });
	
	$('body').bind('mouseup touchend', function(e){
	//$('body').mouseup(function(){
    	scrolling = false;
    });
	
	
		
	function startScrolling(param){	
		var obj = $('.home-product-display ul');
		var maxScroll = ($('.home-product-display').width()-total_width_loaded)
		
		
		if($('html').hasClass('touch')){
			/* ON TOUCH DEVICES, ANIMATE THE "LEFT" PROPERTY SO THAT HOLDING THE ARROW BUTTON WILL ANIMATE THE SAME PROPERTY AS DRAGGING THE PRODUCTS TO THE LEFT AND RIGHT */
			obj.animate({"left": param},10, function(){
				if(parseInt(obj.css("left")) > 0){
					obj.css("left",0)
					scrolling = false;
				}
				if(parseInt(obj.css("left")) < maxScroll){
					obj.css("left",maxScroll + "px")
					scrolling = false;
				}
				if (scrolling){
					startScrolling(param);
				}
			});
		} else {
			/* ON NO-TOUCH DEVICES, ANIMATE THE "MARGIN-LEFT" PROPERTY BECAUSE THE "LEFT" PROPERTY CROPS OUT THE HOVER-INFO BUBBLES. THESE BUBBLES DO NOT EXIST ON TOUCH DEVICES. */
			obj.animate({"margin-left": param},10, function(){
				if(parseInt(obj.css("margin-left")) > 0){
					obj.css("margin-left",0)
					scrolling = false;
				}				
				if(parseInt(obj.css("margin-left")) < maxScroll){
					obj.css("margin-left",maxScroll + "px")
					scrolling = false;
				}				
				if (scrolling){
					startScrolling(param);
				}
			});
		}
	}
	
	
	
	function startDragging(){
		var drag_container_right = parseInt( $('.home-product-display').position().left) + parseInt($('.home-product-display').css("padding-left"));
		var drag_container_width = $drag_container.width();
		
		// set the new boundries for touch screen dragging
		var drag_container_left = ((total_width_loaded - drag_container_right) * -1) + drag_container_width;
		//console.log(drag_container_left)	
		$drag_container.draggable( "option", "containment", [drag_container_left, 0, drag_container_right, 0]  );
	}

});




