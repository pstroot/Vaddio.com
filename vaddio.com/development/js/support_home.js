// JavaScript Document
$(document).ready(function() {
 var transitionSpeed = 300;
	 var categoryListHeight = 0;

	timeoutID = window.setTimeout(slowAlert, 3000);


function slowAlert() {
  console.log($('div.token-input-dropdown').parent().html())
}
	
	if (!Modernizr.mq("screen and (max-width: 600px)")) {
	$("#supportSearchInput").tokenInput("/tokeninput_product_search", {
			hintText: "Enter a product name or model number",
			searchDelay: 300, // The delay, in milliseconds, between the user finishing typing and the search being performed. 
			minChars: 3, // The minimum number of characters the user must enter before a search is performed. 
			resultsLimit: null, // The maximum number of results shown in the drop down. Use null to show all the matching results.
			animateDropdown: false,
			tokenLimit: 1, //The maximum number of results allowed to be selected by the user. Use null to allow unlimited selections.
			//deleteText: "<img src='/images/tokeninput_close.png'>",
			
			resultsFormatter: function(item){ 
				return "<li>" + item.name + "</li>" 
			},
			tokenFormatter: function(item){ 
				return "<li><p>" + item.nameOnly + "</p></li>";
			},
			onResult: function(results) {
				console.log("Results received -> " + results.length); 
				if(results.length > 11){
					console.log("add scrollbar");
					$('div.token-input-dropdown').css({
						"max-height":"20em",
						"overflow":"hidden",
						"overflow-y":"scroll"
					});
				} else {
					console.log("remove scrollbar");
					$('div.token-input-dropdown').css({
						"max-height":"",
						"overflow":"",
						"overflow-y":""
					});
				}
				return results;       	
			},
			onAdd: function(item) {
				//showLoadingIcon();
				if(item.slug == ''){
					window.location = '/search/'+ item.nameOnly;
				} else {
					window.location = '/'+item.slug;
				}
			}				
	});	
	}
	
	
	$('#supportSearchSubmit').click(function(evt){
		evt.preventDefault();

		if($(this).find('li.token-input-token').length > 0){
			var value = $("#supportSearchInput").tokenInput("get");
			window.location = 'product_support.php?id='+value[0].id
		} else if($('#token-input-supportSearchInput').val() != ""){
			var value = $('#token-input-supportSearchInput').val();
			window.location = 'search.php?s=' + escape(value);
		}
	
		var value = $('#token-input-supportSearchInput').val();
		window.location = 'search/' + escape(value);		
	});
		
	
	$('a.choose-a-product-category').click(function(evt){
		evt.preventDefault();
		$('.expandable').slideToggle();
	});
	$('#close-category-window').click(function(evt){
		$('.expandable').slideUp();
	});
	
	$('.category-list-container ul li a').click(function(evt){
		evt.preventDefault();
		categoryListHeight = $('.categorySelector').height();
		var url = $(this).attr("href");
		 $('.choose-category').css("opacity",.4);
		 //console.log(categoryListHeight)
		/*
		$('#preloader').prependTo(".categorySelector");
		$('#preloader').css({
				"margin-left":345,
				"margin-top":60
			});
		$('#preloader').fadeIn(200);
			
		*/
		$.ajax({
			url: url,
			success: function(data) {
				//$('#preloader').hide();
				$('.categorySelector').css("height",$('.categorySelector').height()); // set the height of the container to it's current height
					
				$('.category-detail-container').html(data)						// place the new content on the screen for a split second so we can get the height of it
				var newHeight = $('.category-detail-container').height();
				$('.category-detail-container').empty();							// remove the content so we can do our animation
				
				$('.category-list-container').fadeOut(transitionSpeed,function(){	// fade out the old
					$('.categorySelector').animate({					// animate to the new height
						height: newHeight + 'px'
					}, transitionSpeed, function() {
		 				$('.category-list-container').css("opacity",1);
						$('.category-detail-container').html(data)				// add new content
						$('.category-detail-container').css("display","none");
						$('.category-detail-container').fadeIn(transitionSpeed)	// fade in the new
		 				
					});	
				});
			}
		}); // END AJAX CALL
	});
	
	 $('#choose-a-different-category').live("click",function(evt){
		evt.preventDefault();
		 //console.log("revert to "+categoryListHeight)
		$('.category-detail-container').fadeOut(transitionSpeed,function(){
			$('.categorySelector').animate({							// animate to the new height
						height: categoryListHeight + 'px'
					}, transitionSpeed, function() {
						$('.category-detail-container').empty()					// empty category content
						$('.category-detail-container').css("display","none");
						$('.category-list-container').fadeIn(transitionSpeed)
					});	
					
		})
	});
		 
		 
	divideIntoColumns($('.category-list-container'),4);
	//$('nav.topnav>ul>li:last a').css("border-bottom","none");		
});
	