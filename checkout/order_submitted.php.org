<?

if(isset($_GET['order'])){
	$q = mysql_query("SELECT * FROM `orders` WHERE `id`='".$_GET['order']."'");
	if(mysql_num_rows($q) > 0){
		$qd = mysql_fetch_assoc($q);
		
		echo '<h2>Order Received. Receipt #'.$qd['receipt'].'</h2>';
		
		$personalize = unserialize(stripslashes($qd['personalize']));
		$checkout = unserialize(stripslashes($qd['checkout']));
		echo personalizationOrderDetail($personalize,$checkout,false);
		
		if($personalize['type'] == 'existing' && !isset($_GET['printView'])){
			echo '<div class="printToolNote">
					'.getContent('printToolNote','return').'
				  </div>';
				  
			// this link is now part of the CMS content
			//<p /><a href="javascript:launchwin(\'printable_receipt.html?order='.$_GET['order'].'&printView=true\',\'printable_receipt\',\'width=620,height=690,scrollbars=no\');" >Click Here</a> to print your receipt.
		}
	
	} else {
		echo '<h2>Order Not Found.</h2>';
	}
	
} else {
	echo '<h2>Order Not Found.</h2>';
}

if(!isset($_GET['printView'])){
?>
<p align="right">
<a href="personalization.html">Personalize Another Tool</a>
</p>
<?
} else {
	echo '<br />&nbsp;<p />';
	getContent('printToolNoteOnPrintout');
}
?>