
function selectProductFromPulldown(fieldname){
	var newIndex = fieldname.selectedIndex; 
	if ( newIndex == 0 ) { 
		//alert( "Please select a location!" ); 
	} else { 
		var url = fieldname.options[ newIndex ].value; 
		window.location.assign( url ); 
	} 	
}



$( document ).ready(function() {
	divideIntoColumns($('.home-blueboxes-left .find-products-by-category'),2);
	
	
	
	$('#nav-products .submenu').css("display","block")
	
	
	$('#nav-products .submenu').css("display","")
	
     $(".selectBoxIt_go").selectBoxIt({
          autoWidth: false,
          copyClasses: "container"
     });
	
	
});

