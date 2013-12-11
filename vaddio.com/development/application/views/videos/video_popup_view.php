<div class="hoverWindow">
    <div id="theVideo" class="video">
    	<?= $video_output; ?> 
    </div>
    <h1><?= $video_name; ?></h1>
    <div class='description'><?= $video_description; ?></div>
    <div class="videoLink">Link: <a href='<?= base_url() . "videos/" . $slug; ?>' target="_parent"><?= base_url() . "videos/" . $slug; ?></a></div>
</div>


       
    