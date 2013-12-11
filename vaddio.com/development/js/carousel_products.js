$(function() {
     
     // Initiate
     home_products.init();
     
     // Refresh on screen resize
     $(window).resize(function() {
          home_products.init();
     });
     
     // Assign arrow actions
     $(".home_products_scroller_arrows a").click(function() {
          home_products.animating++;
          if ($(this).hasClass("_left")) home_products.move("left");
          else home_products.move("right");
     });
     
     // Hovers
     $(".home_products_scroller_images li").mouseover(function() {
          var id = $(this).attr("data-id");
          $(".home_products_scroller_callouts li[data-id="+id+"]").addClass("_open");
          var pos = $(this).position();
          var width = $(this).width();
          $(".home_products_scroller_callouts li[data-id="+id+"]").css("left",(pos.left-(width/2))+"px");
     }).mouseout(function() {
          var id = $(this).attr("data-id");
          $(".home_products_scroller_callouts li[data-id="+id+"]").removeClass("_open");
     });
     
});

var home_products = {
     
     animating: 0,
     container: null,
     container_width: 0,
     products_visible: 0,
     product_img_width: 160,
     product_width: 160,
     offset: {
          margin: 0,
          position: 0,
          count: 0
     },
     slide_delay: 500,
     
     init: function() {
          
          // Grab and define container
          this.container = $(".home_products_scroller");
          
          // Get screen width
          this.container_width = $(this.container).width();
          
          // Calculate the number of products that fit within this screen
          this.products_visible = Math.floor(this.container_width / this.product_img_width);
          
          // Calculate new product width
          this.product_width = this.container_width / this.products_visible;
          
          // Resize each product element
          $(this.container).find(".home_products_scroller_images li").css("width",this.product_width+"px");
          
          // Recalculate offsets
          this.offset.margin = -1 * this.offset.count * this.product_width;
          this.offset.position = this.offset.count * this.product_width;
          $(".home_products_scroller_images").css("margin-left",this.offset.margin+"px");
          $(".home_products_scroller_images").css("left",(this.offset.position-this.product_width)+"px");
          
          // Label visibles
          this.label_visibles(true,"none");
          
     },
     
     move: function(dir) {
          
          // Only animate once
          if (this.animating == 1) {
          
               // Set new offsets
               if (dir == "left") this.offset.count--;
               else this.offset.count++;
               this.offset.margin = -1 * this.offset.count * this.product_width;
               this.offset.position = this.offset.count * this.product_width;
               
               // Add _out class
               if (dir == "left") $(".home_products_scroller_images li._visible").last().addClass("_out");
               else $(".home_products_scroller_images li._visible").first().addClass("_out");
               
               home_products.label_visibles(false,dir);
               
               // Adjust margin
               $(".home_products_scroller_images").css("margin-left",this.offset.margin+"px");
               
               // Move items around
               setTimeout(function() {
                    if (dir == "left") {
                         $(".home_products_scroller_images li").last().prependTo(".home_products_scroller_images");
                    } else {
                         $(".home_products_scroller_images li").first().appendTo(".home_products_scroller_images");
                    }
                    $(".home_products_scroller_images").css("left",(home_products.offset.position-home_products.product_width)+"px");
                    $(".home_products_scroller_images li._out").removeClass("_out");
                    home_products.animating = 0;
               },(Modernizr.csstransitions ? 500 : 50));
          
          }
          
     },
     
     label_visibles: function(first,dir) {
          
          var i = 0;
          var n = 1;
          if (!first) {
               if (dir=="right") {
                    n = 2;
               } else {
                    n = 0;
               }
          }
          $(".home_products_scroller_images li").each(function() {
               if ( i >= n && i <= (home_products.products_visible+(n-1)) ) {
                    $(this).addClass("_visible");
               } else {
                    $(this).removeClass("_visible");
               }
               i++;
          });
          
     }
     
};