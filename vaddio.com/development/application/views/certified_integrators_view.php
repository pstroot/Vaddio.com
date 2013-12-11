<div class='header big-ltblue-header'>
    
     <div class="header-leftCol">
        <h1><a href="/get_started">Certified Integrators</a></h1>
        <div class="get-started-nav">
            <a href="/premier-dealers" class='getstarted-header-link premier-dealers-link'><div>VIP EasyUSB Integrators</div></a>
            <a href="/certified-integrators" class='getstarted-header-link certified-integrators-link'><div>Certified Tracking Integrators</div></a>
        </div>
     </div>
    
</div>

<section class='leftCol'>

	<p class='summary'>These tracking installation integrators have undergone extensive training to become certified by Vaddio to install AutoTrak camera tracking system.</p>
    
    <h2 class="isUS">United States</h2>
    <?
    $isUS = "1";
    $location = "";
    foreach($integrators as $i){
        if ($isUS != $i["isUS"]) {
            if ($i["isUS"] == "0") echo '</ul>';
            echo '<h2>International</h2>';
            $isUS = $i["isUS"];
        }
        if ($location != $i["location"]) {
            if ($location != "") echo '</ul>';
            echo '<h3>'.$i["location"].'</h3>';
            echo '<ul class="integrator-list">';
            $location = $i["location"];
        }
        ?>
        <li>
            <div class='icon'><a href="<?= $i['url']; ?>" target="_blank"><img src="<?= $i['logo']; ?>" alt="<?= $i["company"] ;?>" border='0'></a></div>
            <div class='detail'>
                <div class='company'><a href="<?= $i['url']; ?>" target="_blank"><?= $i["company"]; ?></a></div>    
                <div class='name'><?= $i["firstname"]; ?> <?= $i["lastname"]; ?></div> 
                <div class='location'><?= $i["location"]; ?></div>
            </div>
        </li>
        <?
    }
    ?>
    </ul>
    
    <h2>Other</h2>
    <ul class="integrator-list">
        <?
        foreach($integrators_null as $i) {
            ?>
            <li>
                <div class='icon'><a href="<?= $i['url']; ?>" target="_blank"><img src="<?= $i['logo']; ?>" alt="<?= $i["company"] ;?>" border='0'></a></div>
                <div class='detail'>
                    <div class='company'><a href="<?= $i['url']; ?>" target="_blank"><?= $i["company"]; ?></a></div>    
                    <div class='name'><?= $i["firstname"]; ?> <?= $i["lastname"]; ?></div> 
                    <div class='location'><?= $i["location"]; ?></div>
                </div>
            </li>
            <?
        }
        ?>
    </ul>

</section>


<section class="rightCol">
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
</section>
