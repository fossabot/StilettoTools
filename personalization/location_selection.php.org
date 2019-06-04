<?php

$productOptionId = number_format($_SESSION['personalize']['product']['productOptionsId']);

// get locations data
$availableLocations = getField($productOptionId, 'product_options', 'locations');
$availableLocations = explode(",",$availableLocations);

$conditional = "";
foreach($availableLocations as $key => $val){
	if(trim($val) != ""){
		$conditional .= "`id`='$val' OR ";
	}
}

$ab = array('A','B');
$q = mysql_query("SELECT * FROM `locations` WHERE (".substr($conditional,0,(strlen($conditional)-4)).") AND `active`='0' ORDER BY `precedence` ASC, `id` ASC");
if(mysql_num_rows($q) > 0){
	$locations = array();
	while($qd = mysql_fetch_assoc($q)){
		if(!isset($locationId)){
			$locationId = $qd['id'];
		}
		
		foreach($ab as $letter){
			$img = 'uploads/locations/locations_'.$qd['id'].'_image'.$letter.'.jpg';
			if(file_exists($img)){
				$qd['image'.$letter] = $img;
			}
		}
		
		if(!isset($locationKey)){
			$locationKey = 0;
		}
		$locations[] = $qd;
	}
}


echo 'Please select a location to personalize:<p />';
?><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="productList">
			<ul class="productList">
			<?php
			
				foreach($locations as $key => $val){
					echo '<li><a href="#" class="'.($val['id'] == $locationId ? 'sel':'').'" id="location'.$val['id'].'" '.
						 'onclick="updateLocationsPics('.$val['id'].');">'.f($val['title']).'</a></li>';
				}
			
			?>
			</ul>
		</td>
		<td class="locationExamples">
			<div class="locationExamples">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="padding-right:4px;"><?php
						
							echo '<img src="';
							if(isset($locations[$locationKey]['imageA'])){
								echo $locations[$locationKey]['imageA'].'" style="border-color:#fff;';
							} else {
								echo 'images/spacer.gif';
							}
							echo '" id="locationSample1" alt="" />';
						
					?></td>
						<td><?php
						
							echo '<img src="';
							if(isset($locations[$locationKey]['imageB'])){
								echo $locations[$locationKey]['imageB'].'" style="border-color:#fff;';
							} else {
								echo 'images/spacer.gif';
							}
							echo '" id="locationSample2" alt="" />';
						
					?></td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<div class="continueButton" id="continueButton">
	<form action="actions/personalize.php" method="post">
	<input type="hidden" name="step" value="4" />
	<input type="hidden" name="locationId" id="locationId" value="<?=$locationId?>" />
	<input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" />
	</form>
</div>

<div class="hidden">
<?php

	// list all the location sample images here for use with javascript:
	foreach($locations as $key => $val){
		if(isset($val['imageA'])) echo '<img src="'.$val['imageA'].'" id="locationSample1_'.$val['id'].'" alt="" />';
		if(isset($val['imageB'])) echo '<img src="'.$val['imageB'].'" id="locationSample2_'.$val['id'].'" alt="" />';
	}
	
?>
</div>