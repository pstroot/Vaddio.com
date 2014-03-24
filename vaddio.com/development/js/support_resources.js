
function scrollToTop(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
} 
		
$(function() {
     if (location.hash !== "") {
          if ($("a[name='"+location.hash.substr(5)+"']").length > 0) {
               var pos = $("a[name='"+location.hash.substr(5)+"']").offset();
               $("html, body").animate({ scrollTop: pos.top-15 }, "slow");
          }
     }
     $(".resource_center_list li a").click(function() {
          var target = $(this).attr("data-href");
          var pos = $("a[name='"+target+"']").offset();
          $("html, body").animate({ scrollTop: pos.top-15 }, "slow");
     });
     $(".resource_center_tab").click(function() {
          $(".resource_center_tab").removeClass("_active");
          $(".resource_center_list").removeClass("_active");
          if (this.id == "resource_center_tab_products") {
               $(this).addClass("_active");
               $("#resource_center_products").addClass("_active");
          } else {
               $(this).addClass("_active");
               $("#resource_center_other").addClass("_active");
          }
     });
});