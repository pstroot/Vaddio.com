<div class='header big-blue-header support-center'>
    <h1><a href='/'>Support Center</a></h1>
</div>


<div class="leftCol">

    <h2>Resource Library</h2>
    
    
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
