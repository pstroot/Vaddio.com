<?
class EmbedVideo{
	
	var $fixedWidth = NULL;
	var $fixedHeight = NULL;
	var $FlvVideoSkin = "js/swfobject/SteelExternalPlaySeekMute.swf";
	var $autoPlay = false;
	var $showThumbnail = true;
	
	function autoPlay($b){
		$this->autoPlay = $b;
	}
	function showThumbnail($b){
		$this->showThumbnail = $b;
	}
	
	function setFixedWidth($w){
		$this->fixedWidth = $w;
		$this->fixedHeight = NULL;
	}
	function setFixedHeight($h){
		$this->fixedWidth = NULL;
		$this->fixedHeight = $h;
	}
	
	
	function embedVideoByDbRow($dbRow){
		if(is_array($dbRow)){
			$object = new stdClass();
			foreach ($dbRow as $key => $value){
				$object->$key = $value;
			}	
			$dbRow = $object;
		}
		
		$scaleRatio = 1;
		if ($this->fixedWidth  != NULL && $this->fixedHeight  != NULL){
			$width = $this->fixedWidth;
			$height = $this->fixedHeight;
		}else if ($this->fixedWidth  != NULL){
			$scaleRatio = ($this->fixedWidth  / $dbRow->video_width  );
			$width = $dbRow->video_width * $scaleRatio;
			$height = $dbRow->video_height * $scaleRatio;
		}else if ($this->fixedHeight != NULL){
			 $scaleRatio = ($this->fixedHeight / $dbRow->video_height );
			$width = $dbRow->video_width * $scaleRatio;
			$height = $dbRow->video_height * $scaleRatio;
		}else{
			$width  = $dbRow->video_width;
			$height = $dbRow->video_height;
		}
		
		
		$url = base_url() . $dbRow->video_URL;
		
		if (strtoupper($dbRow->video_type) == "VIMEO"){
			return $this->embedVimeo($dbRow->vimeo_id,$width,$height,$dbRow->video_name);
			
		} else if (strtoupper($dbRow->video_type) == "YOUTUBE"){			
			return $this->embedYouTube($dbRow->third_party_video_id,$width,$height);
			
		} else if (strtoupper($dbRow->video_type) == "FLV"){
			return $this->embedFLV($url,$width,$height,$dbRow->video_thumbnail);
			
		} else if (strtoupper($dbRow->video_type) == "AVI") {
			return $this->embedAVI($url,$width,$height); 
			   
    	} else if (strtoupper($dbRow->video_type) == "MOV" || strtoupper($dbRow->video_type) == "MPEG"){
			return $this->embedMPEG($url,$width,$height);
		}
	}
	
	
	
	
	
	
	
    
    function embedVimeo($id,$width,$height,$title){
		
		global $vimeo;
		
		require_once(SERVER_PATH_TO_MAIN . "includes/video/init_vimeo.php");
		$FeaturedVideoError = false;
		try{
			$video = $vimeo->call('vimeo.videos.getInfo', array('video_id' => $id));			
			$width = $video->video[0]->width;
			$height = $video->video[0]->height;
			if ($this->fixedWidth  != NULL && $this->fixedHeight  != NULL){
				print "Set Height to " . $this->fixedHeight . "<BR>";
				print "Set Width to " . $this->fixedWidth . "<BR>";
				$width = $this->fixedWidth;
				$height = $this->fixedHeight;
			} else if ($this->fixedWidth  != NULL){
				$scaleRatio = ($this->fixedWidth  / $width  );
				$width = $width*$scaleRatio;
				$height = $height*$scaleRatio;
			} else if ($this->fixedHeight  != NULL){
				$scaleRatio = ($this->fixedHeight  / $height  );
				$width = $width*$scaleRatio;
				$height = $height*$scaleRatio;
			}
					
		} catch(Exception $e){
			//print $e->getMessage();
			if($e->getCode() == 999){
				// Rate Limit Exceeded;
				// we're not able to get a width and height from the Vimeo API, so give it our best guess
			} else if($e->getCode() == 1){
				$FeaturedVideoError = true;
			}
		}
		
		if(!$FeaturedVideoError){ 
			ob_start();
			?>
		
			<!-- Flash Detection -->
			<script language="javascript" type="text/javascript" src="<?=INCLUDES_DIR;?>flash_detect_min.js"></script>
			<script>
				var flashMessage;
				if(!FlashDetect.installed){
					flashMessage = "This video can't be played with your current setup. Please switch to a browser that provides native H.264 support or install <a href='http://get.adobe.com/flashplayer/' target='_blank'>Adobe Flash Player</a>";
					$('.featured_video h2').after("<div class='videoErrorMessage' id='sadClapper' style='position:absolute;width:420px;'>"+flashMessage+"</div>");
				}
						
			
				 else if((FlashDetect.major < 10) && (is_internetExplorer == true || is_chrome == true)){
					//alert("Flash major: "+ FlashDetect.major);
					//alert("Flash minor: "+ FlashDetect.minor); 
					//alert("Flash revision: "+ FlashDetect.revision); 
					flashMessage = "This video can't be played with your current setup. Please switch to a browser that provides native H.264 support or upgrade your <a href='http://get.adobe.com/flashplayer/' target='_blank'>Adobe Flash Player</a> Plug-in";
					$('.featured_video h2').after("<div class='videoErrorMessage' id='sadClapper' style='position:absolute;width:420px;'>"+flashMessage+"</div>");
					$('iframe').hide();
				}                
			</script>    
	
	  
			<iframe
				src="//player.vimeo.com/video/<?=$id?>?api=1&amp;portrait=0&amp;byline=1&amp;color=cadef6&amp;player_id=featuredVideoPlayer&amp;title=1"
				class="vimeo" 
				id="featuredVideoPlayer"  
				width="<?=$width;?>" 
				height="<?=$height;?>" 
				frameborder="0">
			</iframe>    
			
		
			<?
			return ob_get_clean();
		} // END if(!$FeaturedVideoError){ 
    }
    
	
	
	
	
	
	
	function embedYouTube($id,$width,$height){
   		$playbackControls_height = 35;
		$ratio = ($height/$width)*100;
		ob_start();
		?>
        <div class="video-embed-container-container" style="max-width:<?=$width;?>px">
        <div class="video-embed-container" style="padding-bottom:<?=$ratio;?>%">
        <iframe 
			  src='//www.youtube.com/embed/<?= $id; ?>?&autoplay=<?= $this->autoPlay ? "1" : "0"; ?>&color=white&wmode=transparent&enablejsapi=1' 
              id='youtube_<?= $id; ?>'
			  frameborder='0' 
			  webkitAllowFullScreen mozallowfullscreen allowFullScreen>
		</iframe>
        </div>
        </div>
    	<?
		return ob_get_clean();
	}
       
	   
	   
	   
	   
	   
	   
	   
 	function embedFLV($url,$width,$height,$thumbnail){
		$rnd = rand(1,9999);
		/*	
		if ($this->fixedWidth  != NULL && $this->fixedHeight  != NULL){
			$width = $this->fixedWidth;
			$height = $this->fixedHeight;
		} else if ($this->fixedWidth  != NULL){
			$scaleRatio = ($this->fixedWidth  / $width  );
			$width = $width*$scaleRatio;
			$height = $height*$scaleRatio;
		} else if ($this->fixedHeight  != NULL){
			$scaleRatio = ($this->fixedHeight  / $height  );
			$width = $width*$scaleRatio;
			$height = $height*$scaleRatio;
		}
		*/
		ob_start();			
		?>
        <script language='javascript' type='text/javascript' src='<?= base_url() ?>js/swfobject/swfobject.js'></script>
    	<script type='text/javascript'>
		var flashvars = {
			url: '<?= $url ?>',		
			videoSkin: '<?= base_url() . $this->FlvVideoSkin; ?>',
			doAutoPlay: '<?= $this->autoPlay ? "yes" : "no"; ?>',
			imageName: '<?= $this->showThumbnail ? $thumbnail : ""; ?>'
		};
		var params = {
			bgcolor: '#FFFFFF',
			wmode:'transparent'
		};
		var attributes = {
		  id: 'myDynamicContent_<?=$rnd;?>',
		  name: 'myDynamicContent_<?=$rnd;?>'
		};
		swfobject.embedSWF('<?= base_url() ?>js/swfobject/video.swf', 'flashVideo_<?=$rnd;?>', '<?=$width?>', '<?=($height+40)?>', '8.0.0', '<?= base_url(); ?>js/swfobject/expressInstall.swf',  flashvars, params, attributes);
    	</script>
        
	 	<div id='flashVideo_<?=$rnd;?>' style='height:<?=($height+50)?>px;'>
				<div align='center'><p style='background-color:#CC0000;color:#FFFFFF;font-weight:bold;text-align:center;width:400px;'>
				You'll need Flash player version 8 or later<BR />to display Vaddio product video demos.
				</p></div>
		</div>
		<?
		return ob_get_clean();
    }
    
	
	
	
	
    function embedAVI($url,$width,$height){
		ob_start();
		?>
		<div style='height:<?=$height; ?>px;'>
		<OBJECT
			ID="MediaPlayer"
			classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"
			CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715"
			width=<?=$width; ?> height=<?=$height; ?>
			standby="Loading Microsoft Windows Media Player components..."
			type="application/x-oleobject">
			<PARAM NAME="FileName" VALUE="<?= base_url() . $url ?>">
			<PARAM NAME="TransparentAtStart" Value="false">
			<PARAM NAME="AutoStart" Value="<?= $this->autoPlay ? "true" : "false"; ?>">
			<PARAM NAME="AnimationatStart" Value="true">
			<PARAM NAME="ShowControls" Value="true">
			<PARAM NAME="ShowPositionControls" Value="false">
			<PARAM NAME="ShowStatusBar" Value="true">
			<PARAM NAME="autoSize" Value="true">
			<PARAM NAME="displaySize" Value="1">
			<Embed type="application/x-mplayer2"
				pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=Media&sba=Plugin&"
				src="<?= base_url() . $url ?>"
				Name=MediaPlayer
				AutoStart=<?= $this->autoPlay ? "1" : "0"; ?>
				Width=<?=$width; ?> Height=<?=$height; ?> 
				transparentAtStart=0
				animationAtStart=1
				ShowControls=1
				ShowPositionControls=0
				ShowStatusBar=1
				autoSize=1
				displaySize=1>
			</embed>
		</OBJECT>
		</div>
		<?
		return ob_get_clean();
    }
    
    function embedMPEG($url,$width,$height){
        ob_start();
		?>
        <object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="256" width="320"> 
            <param name="src" value="<?=ABSOLUTE_PATH . $url?>">
            <param name="autoplay" value="<?= $this->autoPlay ? "true" : "false"; ?>">
            <param name="type" value="video/quicktime" height="<?=$height+20; ?>" width="<?=$width; ?>">
            <param name='loop' value="false">
            <param name='scale' value="tofit">
            <param name="controller" value="true">
            <embed 
            	scale="tofit"
            	src="<?=ABSOLUTE_PATH . $url?>" 
                height="<?=$height+20; ?>" 
                width="<?=$width; ?>" 
                controller="true" 
                autoplay="<?= $this->autoPlay ? "true" : "false"; ?>" 
                type="video/quicktime" 
                pluginspage="http://www.apple.com/quicktime/download/"
            >
        </object>
        <?
		return ob_get_clean();
    }
        
       
      
	
}