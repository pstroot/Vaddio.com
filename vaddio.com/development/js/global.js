
/* THIS CAUSED AN ERROR IN IE8 */
//document.addEventListener("touchstart", function(){}, true);



$( document ).ready(function() {


	/* MOBILE NAV DROPDOWN NAVIGATION */
	var pull 		= $('#pull');
		menu 		= $('nav.topnav>ul');
		menuHeight	= menu.height();
	$(pull).on('click', function(e) {
		e.preventDefault();		
		if(menu.css("display") == "none")	$(pull).addClass("active");
		else								$(pull).removeClass("active");
		menu.slideToggle();	
	});
	$(window).resize(function(){
   		var w = $(window).width();
   		if(w > 320 && menu.is(':hidden')) {
   			menu.removeAttr('style');
   		}
	});
	
	
	
	/* SEARCH FIELD - open and close on click */
	$('html.no-touch header .search a').click(function(e){
		e.preventDefault();
		var $theForm = $(this).parent().find('form');
		if($theForm.css('display') == 'none'){
			 $(this).addClass('active');
			$theForm.fadeIn(200)
			$(this).parent().find('form input[name=search]').select();
		} else {
			 $(this).removeClass('active');
			$theForm.fadeOut(200) // clicking the body will prevent the form from submitting when the enter key is clicked if the form has been closed with the input field focused.
		}
	});
	
		
		
	/* SEARCH FORM */
	/* this also applies to teh larger search form on the search results page */
	$('.searchForm').submit(function(e){
		e.preventDefault();
		var searchString = $(this).find('input[name=search]').val();
		var goto = $(this).find('input[name=search_page]').val();
		if(searchString == '') return false;
		window.location = goto + encodeURIComponent(searchString);	
	});
	
	
	// See function at bottom of page
	divideIntoColumns($('.submenu-products .find-products-by-category'),3);

	
	// for form validation. turns error fields red.
	var thisBlock = $('.form-error').closest('.form-block').addClass("form-block-error")
});





/*
FUNCTION divideIntoColumns()
Used in Products sub-menu and on support home page for find-a-category
This takes 1 unordered list (ul) and divides it into multiple unordered lists, each with a class name of col1, col2, col3... Placement and styling of these lists must be done with css
@attr
	- container = the jQuery container that holds the ul element that you would like to divide into columns
	- number_of_columns = the total number of columns you would like to create.
*/
function divideIntoColumns(container,number_of_columns){	
	var theList =  container.children('ul');
	var total = theList.children('li').size();
	var column = 0;
	var items_per_column = Math.ceil(total/number_of_columns);
	var classNames = theList.attr('class');
	for (var i = 0; i < total; i += items_per_column) {
		column++;
		container.append('<ul class="col' + column + '"></ul>');
		container.find(".col" + column).addClass(classNames);
		container.find(".col" + column).html(theList.children('li').splice(0, items_per_column));	
	}
	theList.remove();
}
		
		
		

