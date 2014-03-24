<div class='header big-blue-header support-center'>
    <h1><a href='/'>Support Center</a></h1>
</div>

<h2 class="main-headline">Resource Library</h2>

<div class="leftCol">
    
    <div class="resource_center">
        <div class="resource_center_tabs">
            <div class="resource_center_tab _active" id="resource_center_tab_products">Downloads for Products</div>
            <div class="resource_center_tab" id="resource_center_tab_other">Other Resources</div>
        </div>
        <ul class="resource_center_list _active" id="resource_center_products">
            <? foreach($resources as $r){ ?>
            <li><a data-href='cat_<?= $r["cat_id"]; ?>'><?= $r["cat_name"]; ?></a></li>
            <? } ?>
        </ul>
        <ul class="resource_center_list" id="resource_center_other">
            <? foreach($resources_other as $r){ ?>
            <li><a data-href='cat_<?= $r["cat_id"]; ?>'><?= $r["cat_name"]; ?></a></li>
            <? } ?> 
        </ul>
    </div>
    
    <?php /*
    <p>On This Page: </p>
    
    <ul class='table-of-contents bulleted-list'>
    <? foreach($resources as $r){ ?>    
    	<li><a href="#cat_<?=$r["cat_id"];?>"><?=$r["cat_name"];?></a></li>
    <? } ?>
    <? foreach($resources_other as $r){ ?>    
    	<li><a href="#cat_<?=$r["cat_id"];?>"><?=$r["cat_name"];?></a></li>
    <? } ?>
	</ul>
    
    <hr />
    */ ?>
    <ul class='resource-list'>
    <? foreach($resources as $r){ ?>    
    	<li>
            <a name='cat_<?=$r["cat_id"];?>'></a><?=$r["cat_name"];?>
            <ul>
			<? foreach($r["downloads"] as $d){ ?>
            	<li>
                	<a href='<?= $d["path"]; ?>'><?= $d["name"]; ?></a>
                    <span class='type'><?= $d["type"]; ?></span>
                    <span class='size'><?= $d["size"]; ?></span>
                </li>                
    		<? } ?>
            </ul>  
            <a href='javascript:scrollToTop();' class='back-to-top'>Back to Top</a>  
        </li>
    <? } ?>  
    
    <? foreach($resources_other as $r){ ?>    
    	<li>
            <a name='cat_<?=$r["cat_id"];?>'></a><?=$r["cat_name"];?>
            <ul>
			<? foreach($r["downloads"] as $d){ ?>
            	<li>
                	<a href='<?= $d["path"]; ?>'><?= $d["name"]; ?></a> 
                    <span class='type'><?= $d["type"]; ?></span>
                    <span class='size'><?= $d["size"]; ?></span>
                </li>                
    		<? } ?>
            </ul>   
            <a href='javascript:scrollToTop();' class='back-to-top'>Back to Top</a>   
        </li>
    <? } ?>  
     
    </ul>
    
    
</div><div class="rightCol">
	<? echo modules::run('SupportInfoBlock','product support'); ?>
	<? echo modules::run('SupportInfoBlock','contact'); ?>
	<? echo modules::run('SupportInfoBlock','helpful links'); ?>   
</div>
