<div class='comparison-chart-container'>

<div id="chartHeader"><div id="chartHeader-inner">
	<a href="<?= base_url() . $downloadLink['path']; ?>" target="_blank"><div id="download-link">Download a printable PDF version of this chart</div></a>
</div></div>

<div id="chartLabel" >
	<h1 class="pageHeader">PTZ camera comparison</h1>
    <h2 class="pageHeader">All HD and SD Cameras</h2>
</div>

<div id="scrollLabel">
	<p>Scroll to explore</p>
</div>

<div id="scrollArrow"></div>

<!--<div id="HD_or_SD"></div>-->


<table id="mainTable" class="scrolltable">
	<thead>
     
     <tr id="headerSpacer">
         <th>this column will not display</th>
         <th colspan="<?= count($productArray); ?>"></th>
     </tr>
        
    <!-- locked column headers go here-->
    <tr id="thumbnails">
        <th>this column will not display</th>
        <? foreach($productArray as $product){ ?>
            <th>
				<? if (is_file($product["thumbnail"])){ ?>
                	<img src="<?= "/" . $product["thumbnail"]; ?>" />
                <? } ?>
            </th>
        <? } ?>
    </tr>
      
	<tr id="names">
        <th>this column will not display</th>
        <? 
		$counter = 1;
		foreach($productArray as $product){ 
			?>
            <th class="col_<?=$counter;?>"><div class="cell"><?= $product["name"]; ?></div></th>
            <? 
			$counter++;if($counter > 2) $counter = 1;
		} ?>
	</tr> 

    </thead>




	<tbody>
    <? 
	$counter = 1;
	foreach($rows as $row){ 
		?>
		<tr class="row_<?=$counter;?>">
			<th><div class="cell"><?= $row["row_name"]; ?></div></th>
			<? $counter2 = 1; ?>
			<? foreach($productArray as $product){ 
				?>
				<td class="col_<?=$counter2;?>"><div class="cell"><?= $product["data"]["row_" . $row["row_id"]]; ?></div></td>
				<? 
				$counter2++;if($counter2 > 2) $counter2 = 1;
			} ?>
		</tr>
		<? 
		$counter++;if($counter > 2) $counter = 1;
	} 
	?>
    </tbody>
    
    
</table>

</div> <!-- END <div style="position:relative;"> -->
<script type="text/javascript">
if(typeof tableScroll == 'function'){tableScroll('mainTable');}
</script>