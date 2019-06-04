<?

// this is always re-calculated just before submission
$_SESSION['checkout']['total'] = number_format(($_SESSION['personalize']['price'] + $_SESSION['personalize']['product']['price'] + $_SESSION['checkout']['shipping_method']['price']),2);

?>
Please review your order and click Submit below to continue:<p />
<?=personalizationOrderDetail($_SESSION['personalize'],$_SESSION['checkout'],false);?>
<div align="right" style="padding-top:25px;"><?
		
	if(isset($_SESSION['checkout']['total']) && $_SESSION['checkout']['total'] > 0){ ?>
	<form action="actions/checkout.php" method="post">
	<input type="hidden" name="step" value="order_confirmation" />
	<input type="image" src="images/buttons/submit_order_ini.gif" alt="Submit Order" value="submit" onmouseover="this.src='images/buttons/submit_order_ro.gif';" onmouseout="this.src='images/buttons/submit_order_ini.gif';" />
	</form>
	<? 
	} else {
		echo '<p /><b>Please contact us at 1-800-987-1849 to complete your order</b>';
	} 

?></div>