<?php

$totalWeight = getField($_SESSION['personalize']['product']['productOptionsId'],'product_options','weight');
if(!$totalWeight || $totalWeight == 0){
	$totalWeight = DEFAULTPRODUCTWEIGHT;
}

include("fedex/RateWebServiceClient/Rate/RateWebServiceClient.php5");

?>
<form action="actions/checkout.php" method="post">
<input type="hidden" name="step" value="shipping_method" />
<input type="hidden" name="method" id="method" value="" />
<input type="hidden" name="price" id="price" value="" />
<table cellspacing="0" cellpadding="0" width="400">
<?
	if(is_array($shippingOptions) && count($shippingOptions) > 0){
		?><tr>
			<td colspan="3" style="padding-bottom:15px;">Please select a shipping option from the list below:</td>
		</tr><?
		
		foreach($shippingOptions as $key => $val){
			echo '<tr>';
			echo '	<td width="30"><input type="radio" name="shippingId" id="shippingId" onclick="setShippingMethod(\''.ucwords(strtolower(str_replace('_',' ',$val['name']))).'\',\''.number_format($val['price'],2,'.','').'\')" /></td>';
			echo '	<td>'.ucwords(strtolower(str_replace('_',' ',$val['name']))).'</td>';
			echo '	<td width="60">$'.number_format($val['price'],2,'.',',').'</td>';
			echo '</tr>';
		}
		
		?><tr>
			<td colspan="3" align="right">
				<div class="continueButton" id="continueButton" style="visibility:hidden;">
					<br /><input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" />
				</div></td>
		</tr><?
		
	} else {
		echo '<tr><td align="center" style="padding-top:35px;"><b>
			  	Shipping is not available to your address.<br />
			  	Please contact us at 1-800-987-1849';
		
		echo '</b></td></tr>';
	}
	
?>
</table>
</form>
<?php

if(SHOWDEVHTML){
	echo '<pre>';
	print_r($shippingOptions);
	echo '</pre>';
}
	
?>