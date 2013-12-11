<div class='header big-blue-header'>
    <h1>Events</h1>
</div>




    <div class="tagline">
        Join us at one of the industry events listed below to see first-hand benefits of Vaddio's PTZ cameras and high-end camera control systems.
    </div>
    
    
    <ul class='events-list'>
    <?php
    foreach($events as $e){
        ?><li class="press-list-item">
            <div class='image'>
                <a href="<?= $e["link"]; ?>" target="_blank"><img src="/library?path=e&file=<?= $e["thumbnail"]; ?>" alt="<?=$e["name"];?>" border="0"/></a>
            </div>
            <div class="description">
            	<h2><a href="<?= $e["link"]; ?>" target="_blank"><?=$e["name"]; ?></a></h2>
                <?=$e["displaydate"]; ?><BR />
                <!-- <?=$e["theDate"]?><BR /> -->
                <?=$e["location"]; ?><BR />
                <?=$e["details"];?>                
            </div>
            
        </li><?
    }
    ?>
    </ul>

