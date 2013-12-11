<div class='header big-blue-header'>
    <div class="header-icon"><img src="<?= base_url(); ?>images/tech_partners_icon.png" /></div>
    <h1>Technology Partners</h1>
</div>

<section class='leftCol'>
    <div class="summary">
    At Vaddio, we partner with leading technology vendors who share our commitment to building an environment of success for our integrators and dealers. 
    </div>
    
    <ul class='partner-list'>
        <? foreach($partners as $p){ ?>
        <li>
            <div class='image'><img src='<?= base_url(); ?>images/partners/<?= $p['image']; ?>' /></div>
            <h2><?= $p['name']; ?></h2>
            <div class='description'><?= $p['description']; ?></div>
        </li>
        <? } ?>
    </ul>
</section>



<section class="rightCol">

	<div class='findproducts-container'>
        <h1>Products</h1>
        <? echo modules::run('FindProducts'); ?>
    </div>
    
</section>
