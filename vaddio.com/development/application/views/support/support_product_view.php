<div class='header big-blue-header support-center'>
    <h1><a href='/'>Support Center</a></h1>
</div>

<div class="leftCol">
	<? if (isset($slug_not_found)){ ?>
        <h2>Oops!</h2>
        <h3>We could not find the product indicated by the URL supplied</h3>
        <p style="margin-top:2em;font-size:1.5em;">The product with an id of "<?=$slug;?>" does not exist.</p>
    <? } else { ?>
    
        
        <h2><?= $productDetail["name"]; ?></h2>
        <h3><?= $productDetail["product_number_full"]; ?></h3>
        
        <a href='/products' class='orange-button rounded-corner-button change-product back-arrow-inside-button' >Change Product</a>
    
        <img class='product-image' src='<?= base_url() . $productDetail["product_fullsizeimage"]; ?>' />
    
        <? if (isset($downloads) && count($downloads) > 0){ ?>
        <section class='downloads'>
            <h1>Software &amp; Downloads</h1>
                <ul class='category'>
                    <? foreach($downloads as $cat){ ?>
                        <? if (count($cat["downloads"]) > 0){ ?>
                        <li>
                            
                            <?= $cat["cat_name"]; ?>
                            <ul class='links'>
                            <? foreach($cat["downloads"] as $d){ ?>
                                <li>
                                    <a href='<?= $d["path"]; ?>'><?= $d["name"]; ?></a>
                                    <div class='type'><?= $d["type"]; ?></div>
                                    <div class='size'><?= $d["size"]; ?></div>
                                    <div class='description'><?= $d["description"]; ?></div>
                                </li>
                            <? } // END foreach($cat["downloads"] as $d)?>
                            </ul>
                        </li>
                        <? } // END if (count($cat["downloads"]) > 0)?>
                    
                    
                       
                    <? } // END foreach($downloads as $cat)?>
                </ul>
        </section>
        <? } ?>
    
    
        
        <? if ((isset($faq) && count($faq) > 0) || (isset($faq_docs) && count($faq_docs) > 0)){ ?>
        <section class='faq'>
            <h1>Frequently Asked Questions</h1>
            
            
            <? if (isset($faq) && count($faq) > 0){ ?> 
                <dl>
                    <? foreach($faq as $f){ ?>
                        <dt><?= $f["question"]; ?></dt>
                        <dd><?= $f["answer"]; ?></dd>
                    <? } ?>
                </dl>
            <? } ?>
            
            
            <? if (isset($faq_docs) && count($faq_docs) > 0){ ?> 
                <ul>
                    <? foreach($faq_docs as $f){ ?>
                        <li>
                            <a href='<?= $f["path"]; ?>'><?= $f["link_text"]; ?></a> 
                            <div class='type'><?= $d["type"]; ?></div>
                            <div class='size'><?= $d["size"]; ?></div>
                        </li>
                    <? } ?>
                </ul>
            <? } ?>
            
            
            Have a question about this product you would like answered?
            Contact us at <a href="mailto:support@vaddio.com">support@vaddio.com</a> or call +1 (763) 971-4400 Monday - Friday, 7am - 6pm
    
        </section>
        <? } ?>
        
        
        <? if (
                (!isset($faq) || count($faq) == 0) && 
                (!isset($faq_docs) || count($faq_docs) == 0) && 
                (!isset($downloads) || count($downloads) == 0)
            ){ ?>
        <section class='no-downloads'>
            There are currently no support documents for this product.
        </section>
        <? } ?>
        
    <? } // END if slug_not_found ?>
    
</div><div class="rightCol">
	<? echo modules::run('SupportInfoBlock','product support'); ?>
	<? echo modules::run('SupportInfoBlock','contact'); ?>
	<? echo modules::run('SupportInfoBlock','helpful links'); ?>  
    <? echo modules::run('Promotions'); ?> 
</div>



