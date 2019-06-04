<?php

$toolType = $_SESSION['personalize']['type'];

// get tools data
$q = mysql_query("SELECT * FROM `products` WHERE `active`='0' ORDER BY `precedence` ASC, `id` ASC");
if(mysql_num_rows($q) > 0){
	$products = array();
	while($qd = mysql_fetch_assoc($q)){
		$img = 'uploads/products/products_'.$qd['id'].'_image.jpg';
		if(file_exists($img)){
			$qd['image'] = $img;
		} else {
			$qd['image'] = 'uploads/products/fpo_products.jpg';
		}
		$products[] = $qd;
	}
}

if(isset($_GET['productId'])){
	$productId = $_GET['productId'];
	foreach($products as $key => $val){
		if($val['id'] == $productId){
			$productsKey = $key;
		}
	}
} else {
	$productId = $products[0]['id'];
	$productsKey = 0;
}

// get tool options data
if($toolType == 'new'){
	$query = "SELECT * FROM `product_options` WHERE `products`='$productId' AND `price`>0 AND `active`='0' ORDER BY `precedence` ASC, `id` ASC";
} else {
	$query = "SELECT * FROM `product_options` WHERE `products`='$productId' AND `price`=0 AND `active`='0' ORDER BY `precedence` ASC, `id` ASC";
}

$q = mysql_query($query);
if(mysql_num_rows($q) > 0){
	$products[$productsKey]['options'] = array();
	while($qd = mysql_fetch_assoc($q)){
		$products[$productsKey]['options'][] = $qd;
	}
}


echo 'Please select the tool below '.($toolType=='existing' ? 'you own ':'').'that you would like personalizing:<p />';
?><table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="productList">
			<ul class="productList">
			<?php
			
				foreach($products as $key => $val){
					$productLink = 'personalize_tool_selection.html?productId='.$val['id'];
					echo '<li><a href="'.$productLink.'"'.($val['id'] == $productId ? ' class="sel"':'').'>'.f($val['title']).'</a></li>';
				}
			
			?>
			</ul>
		</td>
		<td class="productDetail">
			<div class="productDetail"><div style="padding:16px 0 32px 16px;">
				<table width="476" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="productImage">
							<img src="<?=$products[$productsKey]['image']?>" alt="<?=f($products[$productsKey]['title'])?>" width="116" height="119" /><?php
						
							/*
							if(trim($products[$productsKey]['url']) != ""){
								echo '<a href="'.$products[$productsKey]['url'].'">Product Details</a>';
							}
							//*/
						
						?></td>
						<td class="productDescription">
						<?php
						
							if(trim($products[$productsKey]['summary']) != ""){
								echo f($products[$productsKey]['summary']);	
							}
							
						?>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="productOptions">
						<?php
						
							if(isset($products[$productsKey]['options']) && count($products[$productsKey]['options']) > 1){
								echo '<small>please select one of the following to personalize</small>
									  <table width="100%" cellspacing="0" cellpadding="0" border="0">';
								foreach($products[$productsKey]['options'] as $key => $val){
									echo '<tr onclick="chooseProductOption('.$productId.','.$val['id'].');">';
									echo '	<td width="24">';
									if($productId == 7 && substr($val['title'],0,2) == "FB") echo '&nbsp;'; 
									else echo '<input type="radio" name="product_option" id="option'.$val['id'].'" value="'.$val['id'].'" onclick="chooseProductOption('.$productId.','.$val['id'].');" />';
									echo '</td>';
									echo '	<td>'.f($val['title']);
									if($productId == 7 && substr($val['title'],0,2) == "FB") echo '<span style="font-size:10px;"> (Available in June)</span>'; 
									echo '</td>';
									if($val['price'] > 0){
										echo '	<td width="55" align="right">$'.number_format($val['price'],2).'&nbsp;</td>';
									}
									echo '</tr>';
								}
								echo '</table>';
							}			
						?>
						</td>
					</tr>
				</table>
			</div></div>
		</td>
	</tr>
</table>

<a name="cb"></a>
<div class="continueButton" id="continueButton" <?php 
	
	// only hide continue button if we're not auto-selecting the ONE option	
	if(count($products[$productsKey]['options']) > 1){
		echo 'style="visibility:hidden;"'; 
	}
	
?>>
	<form action="actions/personalize.php" method="post">
	<input type="hidden" name="step" value="3" />
	<input type="hidden" name="productId" id="productId" value="<?=$productId?>" />
	<input type="hidden" name="productOptionsId" id="productOptionsId" value="<?=$products[$productsKey]['options'][0]['id']?>" />
	<input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" />
	</form>
</div>