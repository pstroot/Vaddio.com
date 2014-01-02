var nbrProductsToDisplay = 6;
	var nbrDocumentsToDisplay = 3;
	var nbrCategoriesToDisplay = 3;
	var nbrVideosToDisplay = 3;
	var nbrPressToDisplay = 3;
	var nbrCaseToDisplay = 3;
	var expandSpeed = 1000;
	
	$(document).ready(function() {
		
		/*
		<? foreach($searchTermArray as $s){ ?>
		$(".resultsBlock").highlight("<?= $s; ?>");
		<? } ?>
		*/
		/*
    	$('form[name=find-a-product-form] input[title]').inputHints();
		
		$('form[name=find-a-product-form]').submit(function(evt){
			evt.preventDefault();
			var value =  $('input[name=searchFor]').val();
			if(value != ""){
				window.location = 'search.php?s=' + value;			
			}
		});
		*/
		var nbrOfProductResults = $('section.product-results .results-spacer>ul>li').length;
		if(nbrOfProductResults > nbrProductsToDisplay){
			var btnTextMore1 = "See more product results ("+(nbrOfProductResults - nbrProductsToDisplay)+")";
			var btnTextLess1 = "See less product results";
			$('section.product-results .results-spacer>ul').after("<div id='moreProductResults'><ul class='resultsBlock'></ul></div>");
			$('section.product-results .results-spacer>ul').after("<a id='productResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore1+"</a>" );
			$("#moreProductResults>ul").append($('section.product-results .results-spacer>ul>li:gt('+(nbrProductsToDisplay-1)+')'));
			$('#moreProductResults').hide();
			$('#productResultsToggle').toggle(function (){
				$(this).text(btnTextLess1);
				$('#moreProductResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore1);
				$('#moreProductResults').slideUp(expandSpeed);
			});


		}
		
		
		var nbrOfDocumentResults = $('section.document-results .results-spacer>ul>li').length;
		if(nbrOfDocumentResults > nbrDocumentsToDisplay){
			var btnTextMore2 = "See more download results ("+(nbrOfDocumentResults - nbrDocumentsToDisplay)+")";
			var btnTextLess2 = "See less download results";
			$('section.document-results .results-spacer>ul').after("<div class='resultsBlock moreResults' id='moreDocumentResults'><ul></ul></div>");
			$('section.document-results .results-spacer>ul').after("<a id='documentResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore2+"</a> ");
			$("#moreDocumentResults>ul").append($('section.document-results .results-spacer>ul>li:gt('+(nbrDocumentsToDisplay-1)+')'));
			$('#moreDocumentResults').hide();
			$('#documentResultsToggle').toggle(function (){
				$(this).text(btnTextLess2);
				$('#moreDocumentResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore2);
				$('#moreDocumentResults').slideUp(expandSpeed);
			});
		}
		
		
		var nbrOfCategoryResults = $('section.category-results .results-spacer>ul>li').length;
		if(nbrOfCategoryResults > nbrCategoriesToDisplay){
			var btnTextMore3 = "See more category results ("+(nbrOfCategoryResults - nbrCategoriesToDisplay)+")";
			var btnTextLess3 = "See less category results";
			$('section.category-results .results-spacer>ul').after("<div class='resultsBlock moreResults' id='moreCategoryResults'><ul></ul></div>");
			$('section.category-results .results-spacer>ul').after("<a id='categoryResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore3+"</a>");
			$("#moreCategoryResults>ul").append($('section.category-results .results-spacer>ul>li:gt('+(nbrCategoriesToDisplay-1)+')'));
			$('#moreCategoryResults').hide();
			$('#categoryResultsToggle').toggle(function (){
				$(this).text(btnTextLess3);
				$('#moreCategoryResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore3);
				$('#moreCategoryResults').slideUp(expandSpeed);
			});
		}
		
		
		var nbrOfVideoResults = $('section.video-results .results-spacer>ul>li').length;
		if(nbrOfVideoResults > nbrVideosToDisplay){
			var btnTextMore4 = "See more video results ("+(nbrOfVideoResults - nbrVideosToDisplay)+")";
			var btnTextLess4 = "See less video results";
			$('section.video-results .results-spacer>ul').after("<div class='resultsBlock moreResults' id='moreVideoResults'><ul></ul></div>");
			$('section.video-results .results-spacer>ul').after("<a id='videoResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore4+"</a>");
			$("#moreVideoResults>ul").append($('section.video-results .results-spacer>ul>li:gt('+(nbrVideosToDisplay-1)+')'));
			$('#moreVideoResults').hide();
			$('#videoResultsToggle').toggle(function (){
				$(this).text(btnTextLess4);
				$('#moreVideoResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore4);
				$('#moreVideoResults').slideUp(expandSpeed);
			});
		}
		
		
		var nbrOfPressResults = $('section.press-results .results-spacer>ul>li').length;
		if(nbrOfPressResults > nbrPressToDisplay){
			var btnTextMore5 = "See more press results ("+(nbrOfPressResults - nbrPressToDisplay)+")";
			var btnTextLess5 = "See less press results";
			$('section.press-results .results-spacer>ul').after("<div class='resultsBlock moreResults' id='morePressResults'><ul></ul></div>");
			$('section.press-results .results-spacer>ul').after("<a id='pressResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore5+"</a>");
			$("#morePressResults>ul").append($('section.press-results .results-spacer>ul>li:gt('+(nbrPressToDisplay-1)+')'));
			$('#morePressResults').hide();
			$('#pressResultsToggle').toggle(function (){
				$(this).text(btnTextLess5);
				$('#morePressResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore5);
				$('#morePressResults').slideUp(expandSpeed);
			});
		}
		
		
		var nbrOfCaseResults = $('section.case-results .results-spacer>ul>li').length;
		if(nbrOfCaseResults > nbrCaseToDisplay){
			var btnTextMore6 = "See more case study results ("+(nbrOfCaseResults - nbrCaseToDisplay)+")";
			var btnTextLess6 = "See less case study results";
			$('section.case-results .results-spacer>ul').after("<div class='resultsBlock moreResults' id='moreCaseResults'><ul></ul></div>");
			$('section.case-results .results-spacer>ul').after("<a id='caseResultsToggle' class='rounded-corner-button orange-button'>"+btnTextMore6+"</a>");
			$("#moreCaseResults>ul").append($('section.case-results .results-spacer>ul>li:gt('+(nbrCaseToDisplay-1)+')'));
			$('#moreCaseResults').hide();
			$('#caseResultsToggle').toggle(function (){
				$(this).text(btnTextLess6);
				$('#moreCaseResults').slideDown(expandSpeed);
			}, function(){
				$(this).text(btnTextMore6);
				$('#moreCaseResults').slideUp(expandSpeed);
			});
		}
		
			
		$('form[name=searchform]').submit(function(evt){
			evt.preventDefault();			
			var value = $(this).find('input[name=searchTerm]').val();
			window.location = '/search/' + escape(value);		
		});
		
	});
	
	/*
	// if there are more than n results, then set up a new table wrapped in a .moreResults div. jquery will turn this on and off.
	if($counter== $nbrProductsToDisplay){
		print "</table>
		
		<div class='moreResults' id='moreProductResults'>
		<table class='resultsBlock'>";
	}
	*/
	
	function toggleMore(div){
		$(div).slideToggle(1000);
	}