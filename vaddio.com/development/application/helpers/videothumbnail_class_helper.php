<?
class VideoThumbnail{
	
	var $fixedWidth = NULL;
	var $fixedHeight = NULL;
	
	
	
	function placeVimeoThumbnail($id, $thumbnail, $title, $description, $slug){		
		$description = $this->trimDescription($description,150);
		$link = base_url() . "videos/" . $slug;		
		return $this->buildThumbnail($id,$link,$title,$description,$thumbnail);
	}
	
	
	function placeThumbnailByDatabaseRow($Row){
		global $vimeo;
		
		$id =  $Row["video_id"];	
		$thumbnail =  $Row["video_thumbnail"];	
		$slug =  $Row["slug"];	
		$type = $Row["video_type"];	
		$link = base_url() . "videos/" . $slug;	
		
		$title =  $Row["video_name"];
		$summary =  $Row["video_summary"];
		$description =  $Row["video_description"];
		
		if(trim($summary) == "") $summary = $description;
		
		$summary = $this->trimDescription($summary,150);
		
		$title = stripslashes($title);
		$summary = stripslashes($summary);
		
		if(!is_file("../" . $thumbnail)){
		//	$thumbnail = "images/video/video_FPO.jpg";
		}
		
		if(strtoupper($type) == "VIMEO"){
			try{
				$video = $vimeo->call('vimeo.videos.getInfo', array('video_id' => $Row["third_party_video_id"]));
				$thumbnail = $video->video[0]->thumbnails->thumbnail[0]->_content;
				$title = $video->video[0]->title;
				$description = $video->video[0]->description;
				$maxCharacters = 150;	
				if(strlen($description) > $maxCharacters){
					$breakAt = strpos($description," ",$maxCharacters);			
					$summary = substr($description,0,$breakAt);
					if($breakAt > 0 && $summary != $description){
						$description = $summary . "...";
					}
				}
			} catch(Exception $e) {
				// there was a problem connecting to the Vimeo API			
			}
		}
			
		return $this->buildThumbnail($id,$link,$title,$summary,$thumbnail);
	}
	

	

	
	function buildThumbnail($id,$link,$title,$summary,$thumbImage){
		$thumb = "
		<div class='videoThumbnail'>
			<a href='" . $link . "' class='fancybox_videoDetail tooltipTrigger' id='".$id."'>
				<div class='image' style='background-image: url(\"" . base_url() . $thumbImage . "\")'>
					<div class='icon'></div>
					<!--<img src='" . base_url() . urlencode($thumbImage) . "' class='thumbnailImage' id='thumbnailImage_".$id."'>-->
				</div>
				<div class='name'>" . $title . "</div>
			</a>
		</div>
				
		<div class='tooltip'>
			<div class='tooltipArrow'></div>
			<h1>" . $title . "</h1>
			<p>" . $summary . "</p>
		</div>
		";
		
		
		return $thumb;
	}
	
	
	
	
	function setFixedWidth($w){
		$this->fixedWidth = $w;
		$this->fixedHeight = NULL;
	}
	
	function setFixedHeight($h){
		$this->fixedWidth = NULL;
		$this->fixedHeight = $h;
	}
	
	function trimDescription($description,$maxCharacters){
		$description = trim($description);
		if(strlen($description) > $maxCharacters){
			$breakAt = strpos($description," ",$maxCharacters);			
			$summary = substr($description,0,$breakAt);
			if($breakAt > 0 && $summary != $description){
				$description = $summary . "...";
			}
		}
		return $description;
	}
	
	
    
       
      
	
}