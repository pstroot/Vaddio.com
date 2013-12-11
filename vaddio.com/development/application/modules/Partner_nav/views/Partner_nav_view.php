<script type="text/javascript">
     $(function() {
          $(".partnernav").click(function() {
               // !Modernizr.mq("screen and (min-width: 842px)") 
               if ($(window).width() < 842) {
                    $(this).find("ul").toggleClass("_show");
               }
          });
     });
</script>

<nav class='partnernav'>
     <div class="partnernav_container">
          <div class="partnernav_logo"><a href="<?= base_url(); ?>dealers">Dealers</a></div>
          <div class="partnernav_arrow"></div>
          <ul>
               <!-- <?= uri_string() ?> -->
               <li class='myinfo<?= substr(uri_string(),0,7)=="my_info" ? " _active" : "" ?>'><a href='<?= base_url(); ?>my_info/editInfo'>My Info</a></li>
               
               <?
               foreach ($categories as $cat){
				   $className = strtolower($cat["cat_name"]);
				   $className .= uri_string()=="dealers/docs/".$cat["slug"]||uri_string()=="dealers/docs/".$cat["slug"]."/" ? " _active" : "";
				   
				   echo "<li class='" . $className . "'>";
				   echo "<a href='" .  base_url() . "dealers/docs/".$cat["slug"]."'>".$cat["cat_name"]."</a>";
				   echo "</li>";
    			}
    			?>

               <li class='job-registration<?= uri_string()=="dealers/job_registration"||uri_string()=="dealers/job_registration/"||uri_string()=="dealers/job_registration_form" ? " _active" : "" ?>'><a href='<?= base_url(); ?>dealers/job_registration'>Job Registration</a></li>
          </ul>
     </div>
</nav>

