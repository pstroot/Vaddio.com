$(function() {
     
     // Check if the experience is mobile
     carousel.mobileCheck();
     $(window).resize(function() {
          carousel.mobileCheck();
     });
     
     // Arrow navigation for mobile
     $(".carousel_mobile_arrow").click(function() {
          if ($(this).hasClass("_left")) {
               carousel.mobile.go("back");
          } else {
               carousel.mobile.go("forward");
          }
     });
     
     // Bind a class changed event
     $(".carousel_panel").bind("classChanged", function(){ 
          carousel.classChanged(this);
     });
     
     // Stop animations when mouse is in carousel text area
     /* Temporarily disabled
     $(".carousel_text").mouseenter(function() {
          carousel.pause();
     }).mouseleave(function() {
          carousel.unpause();
     });
     */
     
});

// Carousel rotation class
var carousel = {
     
     active: false,   // Have the animations been initialized
     current: 1,      // The current carousel open, ID only
     length: 0,       // Panel count
     panels: [],      // Panel elements, array
     panel: null,     // Current panel being animated
     delays: {        // Delay amounts, in ms
          a:8000,     // a: Pause after all animations have run (also initial transition)
          b:1000,     // b: Length of fade out
          c:500,      // c: Delay displaying the graphic after background has been displayed
          d:1000,     // d: Delay displaying the text after the graphic has been displayed
          e:2000,     // e: Length of text animation
          f:3000      // f: Time paused after carousel re-activate (after mouse-leave event)
          },
     isMobile: false, // Is this a mobile screen? (smaller than 601px)
     delayTimeout: null,
     phase: "A",
     target: false,
     end_animations: false,
     
     init: function() {
          
          // Set animations as active
          this.active = true;
          
          // Set initial values
          this.length = $(".carousel_panel").length;
          this.panels = $(".carousel_panel");
          
          // Add _open class to first panel
          if (Modernizr.csstransforms && Modernizr.csstransitions) {
               $(this.panels).first()
                    .addClass("_trans1")
                    .addClass("_trans2")
                    .addClass("_trans3")
                    .addClass("_first")
                    .addClass("_open");
          } else {
               $(this.panels).first()
                    .addClass("_first")
                    .addClass("_open");
               $(".carousel").addClass("_legacy");
          }
          
          // Add nav
          $(".carousel_container").append('<ul class="carousel_nav"></ul>');
          for (var i = 0; i < this.length; i++) {
               $(".carousel_nav").append('<li data-target="'+(i+1)+'">&bull;</li>');
               if (i === 0) $(".carousel_nav li").addClass("_active");
          }
          
          // Setup nav click event
          $(".carousel_nav li").click(function() {
               $(".carousel_nav li").removeClass("_active");
               $(this).addClass("_active");
               carousel.go($(this).attr("data-target"));
          });
          
          // Setup animations
          this.delayTimeout = setTimeout(function() {
               carousel.transition();
          },this.delays.a);
          
     },
     
     mobileCheck: function() {
          
          // Mobile is 600px or smaller
          if ($(window).width() <= 600) {
               this.isMobile = true;
          } else {
               this.isMobile = false;
          }
          
          // If not mobile, initialize desktop/tablet animations
          if (!this.isMobile && !this.active) {
               this.init();
          }
          
          // If mobile, initialize mobile animations
          if (this.isMobile && !this.mobile.active) {
               this.mobile.init();
          }
          
     },
     
     transition: function() {
          
          // Browser support issue? Use jQuery
          this.getCurrentPanel();
          if (!$(".carousel").hasClass("_legacy")) {
          
               // Modern
               this.animations.modern();
          
          } else {
               
               // Legacy
               this.animations.legacy();
               
          }
          
     },
     
     animations: {
          
          modern: function() {
               
               // Update phase
               carousel.phase = "B";
               
               $(carousel.panel)
                    .addClass("_out")
                    .removeClass("_first")
                    .removeClass("_trans1")
                    .removeClass("_trans2")
                    .removeClass("_trans3")
                    .trigger("classChanged");
               
               setTimeout(function() {
                    
                    // Update phase
                    carousel.phase = "C";
                    
                    // Hide original carousel before staging next animation
                    $(carousel.panel).removeClass("_open").removeClass("_out").removeClass("_first");
                    
                    // "Open" next carousel
                    if (carousel.target) {
                         carousel.current = carousel.target;
                         carousel.target = false;
                    } else {
                         carousel.current++;
                         if (carousel.current > carousel.length) carousel.current = 1;
                    }
                    carousel.getCurrentPanel();
                    $(carousel.panel).addClass("_open");
                    
                    // Update nav
                    carousel.updateNav();
                    
                    // Fade in background first
                    $(carousel.panel).addClass("_trans1");
                    
                    // Fade in graphic
                    setTimeout(function() {
                         $(carousel.panel).addClass("_trans2");
                         
                         // Fade in text last
                         setTimeout(function() {
                              $(carousel.panel).addClass("_trans3");
                              
                              // Update phase
                              carousel.phase = "A";
                              
                              // Restart the animation pattern
                              if (carousel.target) {
                                   carousel.transition();
                              } else {
                                   if (!carousel.end_animations) {
                                        carousel.delayTimeout = setTimeout(function() {
                                             carousel.transition();
                                        },carousel.delays.a);
                                   }
                              }
                              
                         },carousel.delays.d);
                         
                    },carousel.delays.c);
                    
               },carousel.delays.b);
               
          },
          
          legacy: function() {
               
               // Update phase
               carousel.phase = "B";
               
               $(carousel.panel).fadeOut("slow",function() {
                    
                    // Update phase
                    carousel.phase = "C";
                    
                    // Close previous panel
                    $(carousel.panel).removeClass("_open");
                    
                    // "Open" next carousel
                    if (carousel.target) {
                         carousel.current = carousel.target;
                         carousel.target = false;
                    } else {
                         carousel.current++;
                         if (carousel.current > carousel.length) carousel.current = 1;
                    }
                    carousel.getCurrentPanel();
                    $(carousel.panel).addClass("_open");
                    carousel.updateNav();
                    $(carousel.panel).fadeIn("slow", function() {
                         
                         // Update phase
                         carousel.phase = "A";
                         
                         // Schedule next transition
                         if (carousel.target) {
                              carousel.transition();
                         } else {
                              carousel.delayTimeout = setTimeout(function() {
                                   carousel.transition();
                              },carousel.delays.a);
                         }
                         
                    });
                    
               });
               
          }
          
     },
     
     go: function(target) {
          
          // Set forced target
          this.target = parseInt(target,10);
          this.end_animations = true;
          
          // If click occurs in Phase A
          if (this.phase == "A") {
          
               // Cancel delay
               clearTimeout(this.delayTimeout);
               
               // Transition
               this.transition();
          
          }
          
     },
     
     pause: function() {
          
          // Cancel delay
          clearTimeout(this.delayTimeout);
          
     },
     
     unpause: function() {
          
          // Schedule next transition
          carousel.delayTimeout = setTimeout(function() {
               carousel.transition();
          },carousel.delays.a);
          
     },
     
     updateNav: function() {
          
          // Clear all nav highlighting
          $(".carousel_nav li").removeClass("_active");
          
          // Add highlighting for current nav item
          $(".carousel_nav li").each(function() {
               if ($(this).attr("data-target") == carousel.current) {
                    $(this).addClass("_active");
               }
          });
          
     },
     
     getCurrentPanel: function() {
          this.panel = $("#carousel_"+this.current);
     },
     
     classChanged: function(obj) {
          //console.log($(obj));
     },
     
     mobile: {
          
          active: false,
          current: 1,
          length: 0,
          panels: [],
          loop: null,
          delay: 5000,
          
          init: function() {
               
               // Set to active
               this.active = true;
               
               // Set initial values
               this.length = $(".carousel_mobile_panel").length;
               this.panels = $(".carousel_mobile_panel");
               
               // Loop animation
               this.loop = setInterval(function() {
                    carousel.mobile.go("forward");
               },this.delay);
               
          },
          
          go: function(dir) {
               
               // First, stop interval
               clearInterval(this.loop);
               
               if (dir == "forward") {
                    
                    // Advance to next panel
                    this.current++;
                    
                    // If no panel, revert to first
                    if (this.current > this.length) {
                         this.current = 1;
                    }
                    
               } else {
                    
                    // Advance to previous panel
                    this.current--;
                    
                    // If no panel, revert to first
                    if (this.current < 1) {
                         this.current = this.length;
                    }
                    
               }
               
               // Clear all open panels
               $(".carousel_mobile_panel").removeClass("_open");
               
               // Open the current panel
               $("#carousel_mobile"+this.current).addClass("_open");
               
               // Reset interval loop
               this.loop = setInterval(function() {
                    carousel.mobile.go("forward");
               },this.delay);
               
          }
          
     }
     
};