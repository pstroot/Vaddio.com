

	<div class="header">
        <div class="headerLeftCol">
            <!-- image displayed here -->
        </div><div class="headerRightCol">    
            <h1>Vaddio Support Center</h1>
            <h2>Access documents and resources for our entire product catalog right here.</h2>
        </div>
    </div>
    
    <div class="finder">
    	
        <div class="panel">
            <label>Find Support by Product</label>
            <a href='/products' class='see-listing'>See a listing of all products</a>
               
            <form name="find-a-product-form">
                <div class="finder-section finder-section-1"> 
                    <div class='text-area-wrapper'><div class='text-area-wrapper-inner'>
                    	<input type="text" name="productfinder" id="supportSearchInput" value="" />
                    </div></div>
                    <div class='go-button-wrapper'>
                    	<input type="submit" name="submit" id="supportSearchSubmit" value="GO" />
                    </div>
                </div>
                   
                <div  class="finder-section finder-section-2">                
                    <span class="or">or</span>
                    <a href='' class='grey-button rounded-corner-button arrow-inside-button choose-a-product-category'>Choose a product category</a>
                </div>
            </form>
           	
            
            <div style="clear:both;"></div>
            
    	</div>
        
        <div class="expandable">
        
         
            <div id="close-category-window"></div>
                
            <div class="categorySelector">
                <div class="category-list-container">
                	<h3>Categories</h3>                       
                     <ul>
                        <?php
                        foreach($categories as $c){
                            print"<li>";
                            printf("<a class='category-link' id='%s' href='/categoryDetail/%s'>%s</a></td>", $c["slug"], $c["slug"], $c["cat_name"]);						
							print "</li>";
                        } 
                        ?>
                    </ul>
                </div>  
                    
                <div class="category-detail-container"></div>
            </div> 
            
        
        	<!--
        	<div class="catgory-detail">
                <h2>Operator Controlled Systems</h2>
                <a href=''>Choose a different category</a>
            
                <ul class="categories-listed">
                    <li class="category">
                    	<a id="productionview-mixer-systems" href="category/productionview-mixer-systems">ProductionVIEW Mixer Systems</a>
                    </li>
                        <ul class="products-listed">
                            <li class="product">
                           		<a id="productionview-hd-mv" href="http://support.vaddio.com/support/productionview-hd-mv">ProductionVIEW HD MV</a>
                            </li>
                            <li class="product">
                            	<a id="productionview_hd-sdi_mv" href="http://support.vaddio.com/support/productionview_hd-sdi_mv">ProductionVIEW HD-SDI MV</a>
                            </li>
                            <li class="product">
                            	<a id="productionview-hd" href="http://support.vaddio.com/support/productionview-hd">ProductionVIEW HD</a>
                            </li>
                            <li class="product">
                            	<a id="productionview-hd-sdi" href="http://support.vaddio.com/support/productionview-hd-sdi">ProductionVIEW HD-SDI</a>
                            </li>
                        </ul>
                    <li class="category">
                    	<a id="productionview-camera-controllers" href="category/productionview-camera-controllers">ProductionVIEW Camera Controllers</a>
                    </li>
                    	<ul class="products-listed">
                            <li class="product">
                                <a id="productionview-precision-camera-controller" href="http://support.vaddio.com/support/productionview-precision-camera-controller">ProductionVIEW Precision Camera Controller</a>
                            </li>
                            <li class="product">
                                <a id="productionview-super-joystick" href="http://support.vaddio.com/support/productionview-super-joystick">ProductionVIEW Super Joystick</a>
                            </li>
                        </ul>
                    <li class="category">
                    	<a id="triggers-for-preset-controllers" href="category/triggers-for-preset-controllers">Triggers for Preset Controllers</a>
                    </li>
                    <ul class="products-listed">
                        <li class="product">
                        	<a id="stepview-mat-small-exposed-75-attached-cable" href="http://support.vaddio.com/support/stepview-mat-small-exposed-75-attached-cable">StepVIEW Mat - Small Exposed - 75' Attached Cable</a>
                        </li>
                        <li class="product">
                        	<a id="stepview-mat-large-exposed-75-attached-cable" href="http://support.vaddio.com/support/stepview-mat-large-exposed-75-attached-cable">StepVIEW Mat - Large Exposed - 75' Attached Cable</a>
                        </li>
                    </ul>
                </ul>
            </div>
            -->
        </div>
    </div>

<div class="resource_center">
    <div class="resource_center_tabs">
        <div class="resource_center_tab _active" id="resource_center_tab_products">Downloads for Products</div>
        <div class="resource_center_tab" id="resource_center_tab_other">Other Resources</div>
    </div>
    <ul class="resource_center_list _active" id="resource_center_products">
        <? foreach($resources as $r){ ?>
        <li><a href='/resources#ani_cat_<?= $r["cat_id"]; ?>'><?= $r["cat_name"]; ?></a></li>
        <? } ?>
    </ul>
    <ul class="resource_center_list" id="resource_center_other">
        <? foreach($resources_other as $r){ ?>
        <li><a href='/resources#ani_cat_<?= $r["cat_id"]; ?>'><?= $r["cat_name"]; ?></a></li>
        <? } ?> 
    </ul>
</div>
    

<div class="leftCol">

	<div class="innerLeftCol">
    
        <? echo modules::run('SupportInfoBlock','vaddio loader'); ?>

    </div><div class="innerRightCol">
    
   		<? foreach($featured as $f){ ?>
        	<h2><?=$f["cat_name"]; ?></h2>
            <? if (count($f["downloads"] > 0)){ ?>
            	<dl>
				<? foreach($f["downloads"] as $d){ ?>
                    <dt><a href='<?= $d["path"]; ?>'><?= $d["displayName"]; ?></a></dt>
                    <dd><?= $d["description"]; ?></dd>                
                <? } ?>	
                </dl>
			<? } ?>            		
        <? } ?>	
    </div>

</div><div class="rightCol">
       
	   
	   <? echo modules::run('SupportInfoBlock','contact'); ?>
	   <? echo modules::run('SupportInfoBlock','warranty'); ?>
        
       
       
</div>
