<? if ($whichBlock == 'contact'){ ?>
	<div class='support-block support-block-contact'>
		<h2>Contact</h2>
		<div class='support-block-content'>
			<?=$contacttext;?>
            <dl>
				<dt>Toll Free</dt><dd><?=$tollfree;?></dd>
				<dt>Phone</dt><dd><?=$phone;?></dd>
				<dt>Email</dt><dd><a href="mailto:<?= $supportemail ?>"><?=$supportemail;?></a></dd>
			</dl>
		</div>
	</div>
<? } ?>




<? if ($whichBlock == 'warranty'){ ?>
	<div class='support-block support-block-warranty'>
		<h2>Warranty Policies</h2>
		<div class='support-block-content'>
			Download warranty information for all Vaddio-made products.
           	<?
			if(count($warranty) > 0){
				echo "<ul>";
				foreach($warranty as $w){
					echo "<li><a href='".$w["path"]."'>".$w["name"].' ('.$w["type"].')</a></li>';
				}
				echo "</ul>";
			}
			?>				
        </div>
    </div>
<? } ?>


<? if ($whichBlock == 'vaddio loader'){ ?>
	<div class='support-block support-block-vaddioloader'>
		<h2>Vaddio Loader</h2>
		<div class='support-block-content'>
			
            <a href="<?= $vaddio_loader_instructions_link; ?>" class="loader-link-1"><?= $vaddio_loader_instructions_name; ?></a>
            <?= $vaddio_loader_instructions_filetype; ?> <?=$vaddio_loader_instructions_filesize; ?>
			
            <a href="<?= $vaddio_loader_link; ?>" class="loader-link-2"><?= $vaddio_loader_name; ?></a>
            <?= $vaddio_loader_filetype; ?> <?=$vaddio_loader_filesize; ?>
		
        </div>
    </div>
<? } ?>


<? if ($whichBlock == 'helpful links'){ ?>
	<div class='support-block support-block-helpfullinks'>
		<h2>Helpful Links</h2>
		<div class='support-block-content'>
			<ul>
                <li><a href='/resources#cat_15'>Distance Charts and Calculators</a></li>                          
				<li><a href='/resources#cat_3'>Software Updates</a></li>
			</ul>
		</div>
	</div>
<? } ?>


<? if ($whichBlock == 'product support'){ ?>
	<div class='support-block support-block-productselect'>
		<h2>Product Support</h2>
		<div class='support-block-content'>
		<? echo form_dropdown('products', $allProducts,$selectedProduct,'onChange="select_product_from_dropdown(this)" class="selectBoxIt_go productSearchSelectBoxIt"'); ?>
		</div>
	</div>
    
    <script>
	function select_product_from_dropdown(sel){
		window.location = "/" + sel.options[sel.selectedIndex].value;
	};
	</script>
<? } ?>