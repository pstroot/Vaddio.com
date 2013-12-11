<div class='header big-blue-header'>
    <h1>Markets</h1>
</div>

<section class='leftCol'>
    <ul class='markets'><? foreach($markets as $m){ ?><li>
            <a href='/markets/<?= $m['slug']; ?>'>
                <div class="title"><?= $m['name']; ?></div>
                <img src=' <?= base_url() . 'images/markets/' . $m['thumbnail']; ?>' />
            </a>
        </li><? } ?></ul>        
</section>



<section class="rightCol">
	<div class='findproducts-container'>
	<h1>Products</h1>
    <? echo modules::run('FindProducts'); ?>
    </div>
</section>